<?php
/**
 * send_email.php - Supabase + PHPMailer integration
 * - Insère le message dans Supabase (via REST) using service_role
 * - Envoie un email vers votre adresse (PHPMailer SMTP si présent, sinon mail())
 */

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once __DIR__ . '/supabase_config.php';

// Destination email
$YOUR_EMAIL = 'mahamadouabdoulahi566@gmail.com';

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function logMessageToFile($name, $email, $message) {
    $logFile = __DIR__ . '/contact_log.txt';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] Name: {$name} | Email: {$email} | Info: {$message}\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

function supabaseInsert($table, $data) {
    $url = rtrim(SUPABASE_URL, '/') . '/rest/v1/' . $table;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $headers = [
        'Content-Type: application/json',
        'apikey: ' . SUPABASE_SERVICE_ROLE_KEY,
        'Authorization: Bearer ' . SUPABASE_SERVICE_ROLE_KEY,
        'Prefer: return=representation'
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    return ['httpCode' => $httpCode, 'result' => $result, 'error' => $err];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $message = isset($_POST['message']) ? sanitizeInput($_POST['message']) : '';

    $errors = [];
    if (empty($name)) $errors[] = 'Le nom est requis';
    if (empty($email)) $errors[] = 'L\'email est requis';
    elseif (!validateEmail($email)) $errors[] = 'L\'email n\'est pas valide';
    if (empty($message)) $errors[] = 'Le message est requis';
    elseif (strlen($message) < 10) $errors[] = 'Le message doit contenir au moins 10 caractères';

    if (!empty($errors)) {
        http_response_code(400);
        logMessageToFile($name, $email, 'VALIDATION_ERROR: ' . implode(' | ', $errors));
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    // Insert into Supabase
    $payload = ['name' => $name, 'email' => $email, 'message' => $message];
    $insert = supabaseInsert(SUPABASE_TABLE_MESSAGES, $payload);

    if ($insert['httpCode'] !== 201 && $insert['httpCode'] !== 200) {
        logMessageToFile($name, $email, 'SUPABASE_INSERT_FAILED: ' . $insert['error'] . ' / ' . $insert['result']);
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la sauvegarde (Supabase)']);
        exit;
    }

    $resp = json_decode($insert['result'], true);
    // Supabase return=representation returns an array with the inserted row
    $messageId = null;
    if (is_array($resp) && isset($resp[0]['id'])) {
        $messageId = $resp[0]['id'];
    }

    // Prepare email body
    $subject = 'Nouveau message de contact - Portfolio';
    $emailBody = "<html><body>";
    $emailBody .= "<h2>Nouveau message de contact</h2>";
    $emailBody .= "<p><strong>Nom:</strong> " . htmlspecialchars($name) . "</p>";
    $emailBody .= "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
    $emailBody .= "<p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>";
    if ($messageId) $emailBody .= "<p><small>ID: #{$messageId}</small></p>";
    $emailBody .= "</body></html>";

    // Try PHPMailer (if installed via Composer)
    $emailSent = false;
    $emailError = null;

    if (file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = MAIL_SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_SMTP_USER;
            $mail->Password = MAIL_SMTP_PASS;
            $mail->SMTPSecure = 'tls';
            $mail->Port = MAIL_SMTP_PORT;

            $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
            $mail->addAddress($YOUR_EMAIL);
            $mail->addReplyTo($email);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $emailBody;

            $mail->send();
            $emailSent = true;
        } catch (Exception $e) {
            $emailError = $mail->ErrorInfo ?? $e->getMessage();
            $emailSent = false;
        }
    } else {
        // Fallback to mail()
        $headers = "MIME-Version: 1.0\\r\\n";
        $headers .= "Content-type: text/html; charset=UTF-8\\r\\n";
        $headers .= "From: " . $email . "\\r\\n";
        $headers .= "Reply-To: " . $email . "\\r\\n";
        $emailSent = @mail($YOUR_EMAIL, $subject, $emailBody, $headers);
        if (!$emailSent) $emailError = 'mail() failed';
    }

    // Log email to Supabase email_logs (best-effort)
    $logPayload = [
        'message_id' => $messageId,
        'recipient_email' => $YOUR_EMAIL,
        'sender_email' => $email,
        'subject' => $subject,
        'status' => $emailSent ? 'sent' : 'failed',
        'error_message' => $emailError
    ];
    $logInsert = supabaseInsert(SUPABASE_TABLE_EMAIL_LOGS, $logPayload);
    if ($logInsert['httpCode'] !== 201 && $logInsert['httpCode'] !== 200) {
        logMessageToFile($name, $email, 'EMAIL_LOG_FAILED: ' . $logInsert['error'] . ' / ' . $logInsert['result']);
    }

    // Local log
    logMessageToFile($name, $email, 'SAVED_TO_SUPABASE. Email: ' . ($emailSent ? 'SENT' : 'FAILED - ' . $emailError));

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Message reçu et sauvegardé (Supabase)',
        'messageId' => $messageId,
        'emailStatus' => $emailSent ? 'sent' : 'saved',
    ]);
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
exit;

?>

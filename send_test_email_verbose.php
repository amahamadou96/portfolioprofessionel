<?php
/**
 * send_test_email_verbose.php
 * - Version verbeuse du test SMTP (affiche le log SMTP détaillé)
 * - Lit les identifiants via supabase_config.php
 */
require_once __DIR__ . '/supabase_config.php';

header('Content-Type: text/plain; charset=utf-8');

if (empty(MAIL_SMTP_USER) || empty(MAIL_SMTP_PASS)) {
    echo "SMTP credentials not set in .env (MAIL_SMTP_USER / MAIL_SMTP_PASS).\n";
    exit(1);
}

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "Composer dependencies not found. Run: composer require phpmailer/phpmailer\n";
    exit(1);
}

require_once __DIR__ . '/vendor/autoload.php';

$YOUR_EMAIL = 'mahamadouabdoulahi566@gmail.com';

$mail = new PHPMailer\PHPMailer\PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = MAIL_SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = MAIL_SMTP_USER;
    $mail->Password = MAIL_SMTP_PASS;
    $mail->SMTPSecure = 'tls';
    $mail->Port = MAIL_SMTP_PORT;

    // Verbose debug output
    $mail->SMTPDebug = 2; // show client and server messages
    $mail->Debugoutput = function($str, $level) {
        echo "[SMTP debug level $level] $str\n";
    };

    $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
    $mail->addAddress($YOUR_EMAIL);
    $mail->Subject = 'Test SMTP Verbose - Portfolio';
    $mail->isHTML(true);
    $mail->Body = '<p>Test SMTP verbose</p>';

    $mail->send();
    echo "\nEmail envoyé avec succès à {$YOUR_EMAIL}\n";
    exit(0);
} catch (Exception $e) {
    echo "\nException: " . ($mail->ErrorInfo ?? $e->getMessage()) . "\n";
    exit(2);
}

?>

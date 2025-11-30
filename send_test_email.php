<?php
/**
 * send_test_email.php
 * - Test SMTP send using PHPMailer (reads credentials from .env via supabase_config.php)
 * - If Composer/PHPMailer is not installed, prints installation instructions
 */
require_once __DIR__ . '/supabase_config.php';

$YOUR_EMAIL = 'mahamadouabdoulahi566@gmail.com';

header('Content-Type: text/plain; charset=utf-8');

// Check SMTP config
if (empty(MAIL_SMTP_USER) || empty(MAIL_SMTP_PASS)) {
    echo "SMTP credentials not set in .env (MAIL_SMTP_USER / MAIL_SMTP_PASS).\n";
    echo "Please add your SMTP user and App Password to .env and retry.\n";
    exit(1);
}

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "Composer dependencies not found.\n";
    echo "Install Composer (https://getcomposer.org/) and run:\n";
    echo "  cd \"d:\\mes projet personel\\portfolio\"\n";
    echo "  composer require phpmailer/phpmailer\n";
    exit(1);
}

require_once __DIR__ . '/vendor/autoload.php';

$mail = new PHPMailer\PHPMailer\PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = MAIL_SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = MAIL_SMTP_USER;
    $mail->Password = MAIL_SMTP_PASS;
    $mail->SMTPSecure = 'tls';
    $mail->Port = MAIL_SMTP_PORT;

    $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);
    $mail->addAddress($YOUR_EMAIL);
    $mail->Subject = 'Test SMTP - Portfolio';
    $mail->isHTML(true);
    $mail->Body = '<p>Ceci est un test SMTP depuis votre portfolio.</p>';

    $mail->send();
    echo "Email envoyé avec succès à {$YOUR_EMAIL}\n";
    file_put_contents(__DIR__ . '/contact_log.txt', '['.date('Y-m-d H:i:s').'] Test email SENT to '.$YOUR_EMAIL."\n", FILE_APPEND);
    exit(0);
} catch (Exception $e) {
    echo "Erreur lors de l'envoi: " . $mail->ErrorInfo . "\n";
    file_put_contents(__DIR__ . '/contact_log.txt', '['.date('Y-m-d H:i:s').'] Test email FAILED: '.($mail->ErrorInfo ?? $e->getMessage())."\n", FILE_APPEND);
    exit(2);
}

?>

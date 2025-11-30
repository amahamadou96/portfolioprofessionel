<?php
// env_check.php - quick script to verify env values are loaded
require_once __DIR__ . '/supabase_config.php';

// Mask secret for display
function mask($s) {
    if (empty($s)) return '(empty)';
    $len = strlen($s);
    if ($len <= 8) return str_repeat('*', $len);
    return substr($s,0,4) . str_repeat('*', max(0,$len-8)) . substr($s,-4);
}

header('Content-Type: text/plain; charset=utf-8');

echo "SUPABASE_URL=" . SUPABASE_URL . "\n";
echo "SUPABASE_SERVICE_ROLE_KEY=" . mask(SUPABASE_SERVICE_ROLE_KEY) . "\n";
echo "SUPABASE_TABLE_MESSAGES=" . SUPABASE_TABLE_MESSAGES . "\n";

echo "MAIL_SMTP_HOST=" . MAIL_SMTP_HOST . "\n";
echo "MAIL_SMTP_PORT=" . MAIL_SMTP_PORT . "\n";
echo "MAIL_SMTP_USER=" . MAIL_SMTP_USER . "\n";
echo "MAIL_FROM_EMAIL=" . MAIL_FROM_EMAIL . "\n";

// Quick Supabase test: try a GET to /rest/v1 to ensure URL reachable (no key)
$testUrl = rtrim(SUPABASE_URL, '/') . '/rest/v1/';
$ch = curl_init($testUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['apikey: ' . SUPABASE_SERVICE_ROLE_KEY, 'Authorization: Bearer ' . SUPABASE_SERVICE_ROLE_KEY]);
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err = curl_error($ch);
curl_close($ch);

echo "Supabase REST base URL test HTTP code: " . ($code ?: '(no response)') . "\n";
if ($err) echo "curl error: " . $err . "\n";

?>

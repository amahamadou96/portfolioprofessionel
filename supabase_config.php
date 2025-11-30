<?php
/**
 * supabase_config.php
 * - Charge automatiquement un fichier `.env` situé à la racine du projet
 * - Définit les constantes utilisées par `send_email.php`
 * NOTE: Le fichier `.env` ne doit jamais être commité dans un dépôt public.
 */

// Simple loader .env (supporte KEY=VALUE, ignorera les lignes vides et commentaires #)
function load_dotenv($path) {
	if (!file_exists($path)) return [];
	$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$env = [];
	foreach ($lines as $line) {
		$line = trim($line);
		if ($line === '' || $line[0] === '#') continue;
		if (strpos($line, '=') === false) continue;
		list($key, $value) = explode('=', $line, 2);
		$key = trim($key);
		$value = trim($value);
		// Remove surrounding quotes if present
		if ((substr($value,0,1) === '"' && substr($value,-1) === '"') || (substr($value,0,1) === "'" && substr($value,-1) === "'")) {
			$value = substr($value, 1, -1);
		}
		$env[$key] = $value;
	}
	return $env;
}

// Try to load .env from project root
$envPath = __DIR__ . '/.env';
$env = load_dotenv($envPath);

// Helper to get env value or fallback
function env_get($key, $default = null) {
	global $env;
	if (isset($env[$key]) && $env[$key] !== '') return $env[$key];
	// fallback to getenv
	$g = getenv($key);
	if ($g !== false) return $g;
	return $default;
}

// Required Supabase settings
define('SUPABASE_URL', env_get('SUPABASE_URL', ''));
define('SUPABASE_SERVICE_ROLE_KEY', env_get('SUPABASE_SERVICE_ROLE_KEY', ''));

// Optional: table names (defaults kept for compatibility)
define('SUPABASE_TABLE_MESSAGES', env_get('SUPABASE_TABLE_MESSAGES', 'contact_messages'));
define('SUPABASE_TABLE_EMAIL_LOGS', env_get('SUPABASE_TABLE_EMAIL_LOGS', 'email_logs'));

// SMTP settings (used by send_email.php via PHPMailer fallback)
define('MAIL_SMTP_HOST', env_get('MAIL_SMTP_HOST', 'smtp.gmail.com'));
define('MAIL_SMTP_PORT', intval(env_get('MAIL_SMTP_PORT', 587)));
define('MAIL_SMTP_USER', env_get('MAIL_SMTP_USER', ''));
define('MAIL_SMTP_PASS', env_get('MAIL_SMTP_PASS', ''));
define('MAIL_FROM_EMAIL', env_get('MAIL_FROM_EMAIL', 'no-reply@localhost'));
define('MAIL_FROM_NAME', env_get('MAIL_FROM_NAME', 'Portfolio'));

// If some essential values are missing, log a warning to a file (do not expose secrets)
if (empty(SUPABASE_URL) || empty(SUPABASE_SERVICE_ROLE_KEY)) {
	$warn = '[' . date('Y-m-d H:i:s') . '] WARNING: Missing SUPABASE_URL or SUPABASE_SERVICE_ROLE_KEY in .env\n';
	file_put_contents(__DIR__ . '/contact_log.txt', $warn, FILE_APPEND);
}

?>
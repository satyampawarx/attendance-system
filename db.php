<?php
/*
 * DB connection.
 * Credentials ata environment variables madhun yetat.
 * Docker var run karताna he pass kara:
 *   docker run -e DB_HOST=... -e DB_PORT=... -e DB_NAME=... -e DB_USER=... -e DB_PASSWORD=... -e DB_SSLMODE=require ...
 * Env var set nasel tar khalचे fallback values vaparले jातील (जुनी credentials),
 * pan production मध्ये नक्की env vars sets kara आणि हा hardcoded fallback काढून टाका.
 */

$db_host     = getenv('DB_HOST')     ?: 'ep-wandering-sea-a16rzjhf-pooler.ap-southeast-1.aws.neon.tech';
$db_port     = getenv('DB_PORT')     ?: '5432';
$db_name     = getenv('DB_NAME')     ?: 'attendance';
$db_user     = getenv('DB_USER')     ?: 'neondb_owner';
$db_password = getenv('DB_PASSWORD') ?: 'npg_aM9uDmfJd3Fg';
$db_sslmode  = getenv('DB_SSLMODE')  ?: 'require';

$conn_string = "host=$db_host port=$db_port dbname=$db_name user=$db_user password=$db_password sslmode=$db_sslmode";

$conn = @pg_connect($conn_string);

if (!$conn) {
    // User la generic message, actual error kadhi screen var dakhvu naka (info leak)
    error_log("DB connection failed: " . pg_last_error());
    die("Database connection failed. Please try again later.");
}
?>

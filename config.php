<?php
$host   = getenv('DB_HOST') ?: 'bancodedados-b2r5tj.db.enzonic.com';
$port   = getenv('DB_PORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: 'main';
$user   = getenv('DB_USER') ?: 'u_hjgpcuutth';
$pass   = getenv('DB_PASS') ?: '';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

if (!in_array($host, ['localhost', '127.0.0.1'], true)) {
    if (defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) {
        $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
    }
}

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    error_log('Erro de conexão MySQL: ' . $e->getMessage());
    die("Erro de conexão com o banco de dados.");
}

<?php
$host = getenv('DB_HOST') ?: 'bancodedados-b2r5tj.db.enzonic.com';
$user = getenv('DB_USER') ?: 'u_hjgpcuutth';
$pass = getenv('DB_PASS') ?: '';
$db   = getenv('DB_NAME') ?: 'main';
$port = (int) (getenv('DB_PORT') ?: 3306);

$mysqli = mysqli_init();
$mysqli->ssl_set(null, null, null, null, null);
if (!$mysqli->real_connect($host, $user, $pass, $db, $port, null, MYSQLI_CLIENT_SSL)) {
    die('Erro de conexão com o banco de dados.');
}

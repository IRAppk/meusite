<?php
// config.php
$host = 'localhost';
$dbname = 'bancodedados';
$user = 'root'; // TROQUE EM PRODUÇÃO
$pass = '';     // NUNCA DEIXE VAIZO EM PRODUÇÃO

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Em produção, logar o erro e mostrar mensagem genérica
    die("Erro de conexão com o banco de dados.");
}
?>
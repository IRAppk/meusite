<?php
// Inicia a sessão para salvar o aviso que a index.php vai ler
session_start();

$conn = new mysqli("localhost", "root", "", "bancodedados");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$nome = $_POST['nome'];
$email = $_POST['email'];
$celular = $_POST['celular'];
$mensagem = $_POST['mensagem'];

$sql = "INSERT INTO mensagens (nome, email, celular, mensagem) VALUES ('$nome', '$email', '$celular', '$mensagem')";

if ($conn->query($sql) === TRUE) {
    // Guarda o status de sucesso na sessão
    $_SESSION['status_envio'] = [
        'icon' => 'success',
        'title' => 'Mensagem enviada com sucesso!'
    ];
} else {
    // Guarda o status de erro se algo falhar
    $_SESSION['status_envio'] = [
        'icon' => 'error',
        'title' => 'Erro ao enviar: ' . $conn->error
    ];
}

$conn->close();

// Redireciona de forma limpa pelo servidor de volta para a index
header("Location: index.php");
exit;
?>
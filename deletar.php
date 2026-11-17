<?php
// Inicia a sessão para salvar o aviso do resultado da exclusão
session_start();

$conn = new mysqli("localhost", "root", "", "bancodedados");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se o ID foi enviado e se é um número válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Proteção simples contra SQL Injection

    $sql = "DELETE FROM mensagens WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['status_admin'] = [
            'icon' => 'success',
            'title' => 'Mensagem excluída com sucesso!'
        ];
    } else {
        $_SESSION['status_admin'] = [
            'icon' => 'error',
            'title' => 'Erro ao excluir: ' . $conn->error
        ];
    }
    
    // Volta direto para a seção correta das mensagens no painel admin
    header("Location: admin.php#mensagens");
    exit;

} else {
    // Se o ID for inválido, apenas retorna pro admin
    header("Location: admin.php");
    exit;
}

$conn->close();
?>
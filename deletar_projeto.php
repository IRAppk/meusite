<?php
// 1. Inicia a sessão na primeira linha para conseguir enviar o aviso
session_start();

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "bancodedados");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// Verifica se o ID foi enviado pela URL e se é um número válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    
    /* PEGA O ID E PROTEGE (Garante que é um número inteiro) */
    $id = intval($_GET['id']);

    /* DELETA O PROJETO */
    $sql = "DELETE FROM projetos WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // 2. Guarda o status de sucesso na sessão
        $_SESSION['status_admin'] = [
            'icon' => 'success',
            'title' => 'Projeto excluído com sucesso!'
        ];
    } else {
        // 3. Guarda o status de erro caso falhe no banco
        $_SESSION['status_admin'] = [
            'icon' => 'error',
            'title' => 'Erro ao excluir projeto: ' . $conn->error
        ];
    }
} else {
    // Caso alguém tente acessar o arquivo direto sem passar um ID válido
    $_SESSION['status_admin'] = [
        'icon' => 'error',
        'title' => 'ID de projeto inválido.'
    ];
}

$conn->close();

// 4. Redireciona de volta de forma limpa sem travar a tela
header("Location: projetos.php");
exit;
?>
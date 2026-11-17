<?php
// 1. Inicia a sessão na primeira linha para conseguir passar o aviso para a index.php
session_start();

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "bancodedados"
);

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// Pega os dados do formulário
$nome = $_POST['nome'];
$mensagem = $_POST['mensagem'];

// Insere no banco de dados
$sql = "INSERT INTO feedbacks(nome, mensagem) VALUES('$nome', '$mensagem')";

if($conn->query($sql) === TRUE){
    // 2. Guarda o status de sucesso na sessão (usando 'status_envio' que sua index já lê)
    $_SESSION['status_envio'] = [
        'icon' => 'success',
        'title' => 'Feedback enviado com sucesso!'
    ];
}else{
    // 3. Guarda o status de erro caso falhe
    $_SESSION['status_envio'] = [
        'icon' => 'error',
        'title' => 'Erro ao enviar feedback: ' . $conn->error
    ];
}

$conn->close();

// 4. Redireciona de volta de forma limpa para a seção de feedbacks do site
header("Location: index.php#feedbacks");
exit;
?>
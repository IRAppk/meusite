<?php

$conn = new mysqli("localhost", "root", "", "bancodedados");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$nome = $_POST['nome'];
$link = $_POST['link'];
$imagem = $_POST['imagem'];
$descricao = $_POST['descricao'];

$sql = "INSERT INTO projetos
(nome, link, imagem, descricao)

VALUES

('$nome', '$link', '$imagem', '$descricao')";

if($conn->query($sql) === TRUE){

    header("Location: admin.php");

}else{

    echo "Erro: " . $conn->error;
}

$conn->close();

?>
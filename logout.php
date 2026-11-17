<?php
session_start();
session_unset(); // Limpa as variáveis de sessão
session_destroy(); // Destrói a sessão

// Redireciona para a página inicial do site (público)
header("Location: index.php");
exit();
?>
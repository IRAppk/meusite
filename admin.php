<?php
session_start();

// Lógica de segurança
if (!isset($_SESSION['admin_autenticado']) || $_SESSION['admin_autenticado'] !== true) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "bancodedados");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// Contagem total de mensagens
$sql_mensagens = "SELECT COUNT(*) as total FROM mensagens";
$result_mensagens = $conn->query($sql_mensagens);
$row_mensagens = $result_mensagens->fetch_assoc();
$totalMensagens = $row_mensagens['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - BRN ADMIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0a0a0a;
            color: white;
            font-family: Arial;
            display: flex;
        }

        /* MENU LATERAL */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #111;
            padding: 30px;
            position: fixed;
            display: flex;
            flex-direction: column;
        }

        .logo {
            color: #00ff08;
            font-size: 28px;
            margin-bottom: 40px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar a {
            display: block;
            color: #ccc;
            text-decoration: none;
            margin: 20px 0;
            padding: 15px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #00ff08;
            background: #1a1a1a;
            transform: translateX(5px);
        }

        .sidebar i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar .btn-logout {
            margin-top: auto;
            color: #ff4444;
        }

        .sidebar .btn-logout:hover {
            background: rgba(255, 68, 68, 0.1);
            color: #ff4444;
        }

        /* CONTEÚDO */
        .main {
            margin-left: 250px;
            width: 100%;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        h1 {
            color: #00ff08;
            font-size: 32px;
        }

        /* CARDS */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: #111;
            padding: 30px;
            border-radius: 20px;
            border: 1px solid #1f1f1f;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px #00ff0844;
        }

        .card h2 {
            color: #00ff08;
            font-size: 42px;
            margin-bottom: 10px;
        }

        .card p {
            color: #ccc;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            background: #00ff08;
            border-radius: 50%;
            margin-top: 10px;
            box-shadow: 0 0 10px #00ff08;
        }

        /* SEÇÃO DE BOAS-VINDAS */
        .welcome-section {
            background: #111;
            padding: 30px;
            border-radius: 20px;
            border: 1px solid #1f1f1f;
            margin-top: 20px;
        }

        .welcome-section h2 {
            color: #00ff08;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .welcome-section p {
            color: #ccc;
            line-height: 1.6;
        }

        .welcome-section ul {
            margin-top: 15px;
            list-style: none;
        }

        .welcome-section li {
            color: #ccc;
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
        }

        .welcome-section li::before {
            content: "✓";
            color: #00ff08;
            position: absolute;
            left: 0;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="logo">
        <i class="fa-solid fa-shield-halved"></i> BRN ADMIN
    </div>

    <a href="admin.php" style="color:#00ff08; background:#1a1a1a;">
        <i class="fa-solid fa-chart-line"></i> Dashboard
    </a>

    <a href="mensagens.php">
        <i class="fa-solid fa-envelope"></i> Mensagens
    </a>

    <a href="projetos.php">
        <i class="fa-solid fa-image"></i> Projetos
    </a>

    <a href="index.php">
        <i class="fa-solid fa-globe"></i> Ver Site
    </a>

    <a href="logout.php" class="btn-logout">
        <i class="fa-solid fa-right-from-bracket"></i> Sair
    </a>
</div>

<div class="main">
    <div class="header">
        <h1>Painel Administrativo</h1>
        <div style="color: #888; font-size: 14px;">
            <i class="fa-solid fa-calendar"></i> <?php echo date('d/m/Y'); ?>
        </div>
    </div>

    <div class="cards">
        <div class="card">
            <h2><?php echo $totalMensagens; ?></h2>
            <p>Total de Mensagens</p>
            <div style="color: #00ff08; font-size: 14px; margin-top: 5px;">
                <i class="fa-solid fa-inbox"></i> Caixa de entrada
            </div>
        </div>

        <div class="card">
            <h2>Sistema</h2>
            <p>Status do Site</p>
            <h4>Online</h4>
        </div>

        <div class="card">
            <h2>Projetos</h2>
            <p>Gerencie seu portfólio</p>
            <div style="color: #00ff08; font-size: 14px; margin-top: 5px;">
                <i class="fa-solid fa-layer-group"></i> Área de gestão
            </div>
        </div>
    </div>

    <div class="welcome-section">
        <h2>Resumo do Painel</h2>
        <p>
            Bem-vindo ao painel administrativo. Aqui você tem uma visão geral do sistema. 
            Utilize o menu lateral para acessar as áreas específicas:
        </p>
        <ul>
            <li><strong>Mensagens:</strong> Visualize e gerencie os contatos recebidos</li>
            <li><strong>Projetos:</strong> Cadastre e edite seus projetos</li>
            <li><strong>Ver Site:</strong> Acesse o site em produção</li>
        </ul>
    </div>
</div>

</body>
</html>
<?php
session_start();

// CONFIGURAÇÃO DA SENHA
// Em produção, use password_hash() e salve no banco de dados. 
// Para este exemplo, usamos uma senha fixa simples.
$senha_correta = "devadmin"; // Mude para sua senha desejada

$erro = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senha_digitada = $_POST['senha'];

    if ($senha_digitada === $senha_correta) {
        // Senha correta: Cria a variável de sessão e libera o acesso
        $_SESSION['admin_autenticado'] = true;
        $_SESSION['nome_admin'] = "Bruno"; // Opcional: nome do admin
        
        // Redireciona para o painel
        header("Location: admin.php");
        exit();
    } else {
        $erro = "Senha incorreta. Tente novamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BRN Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #0a0a0a;
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #111;
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 350px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 255, 8, 0.1);
            border: 1px solid #222;
        }
        .logo {
            color: #00ff08;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #ccc;
        }
        .input-group input {
            width: 100%;
            padding: 12px;
            background: #1b1b1b;
            border: 1px solid #333;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            outline: none;
            transition: 0.3s;
        }
        .input-group input:focus {
            border-color: #00ff08;
            box-shadow: 0 0 8px rgba(0, 255, 8, 0.2);
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #00ff08;
            color: black;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: #00cc06;
            transform: translateY(-2px);
        }
        .error-msg {
            background: rgba(255, 0, 0, 0.1);
            color: #ff4444;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .footer-text {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <i class="fa-solid fa-shield-halved"></i> BRN ADMIN
        </div>
        
        <?php if ($erro): ?>
            <div class="error-msg">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label for="senha">Senha de Acesso</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required autofocus>
            </div>
            <button type="submit" class="btn-login">
                <i class="fa-solid fa-right-to-bracket"></i> Entrar no Painel
            </button>
        </form>

        <p class="footer-text">Acesso restrito a administradores autorizados.</p>
    </div>
</body>
</html>
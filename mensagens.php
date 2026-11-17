<?php
session_start();

// Lógica de segurança
if (!isset($_SESSION['admin_autenticado']) || $_SESSION['admin_autenticado'] !== true) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "Bancodedados");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$sql = "SELECT * FROM mensagens ORDER BY data_envio DESC";
$result = $conn->query($sql);
$totalMensagens = $result->num_rows;

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Mensagens - BRN ADMIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        *{ margin:0; padding:0; box-sizing:border-box; }
        body{ background:#0a0a0a; color:white; font-family:Arial; display:flex; }
        .sidebar{ width:250px; height:100vh; background:#111; padding:30px; position:fixed; display:flex; flex-direction:column; }
        .logo{ color:#00ff08; font-size:24px; margin-bottom:40px; font-weight:bold; display:flex; align-items:center; gap:10px; }
        .sidebar a{ display:block; color:#ccc; text-decoration:none; margin:15px 0; padding:10px; border-radius:8px; transition:0.3s; }
        .sidebar a:hover{ color:#00ff08; background:#1a1a1a; }
        .sidebar i{ margin-right:10px; width:20px; text-align:center; }
        .sidebar .btn-logout { margin-top: auto; color: #ff4444; }
        .sidebar .btn-logout:hover { background: rgba(255, 68, 68, 0.1); color: #ff4444; }
        
        .main{ margin-left:250px; width:100%; padding:30px; }
        .btn{ padding:8px 15px; border:none; border-radius:8px; cursor:pointer; font-weight:bold; }
        .btn-back{ background:#333; color:white; margin-bottom:20px; }
        .btn-back:hover{ background:#444; }
        .btn-delete{ background:#ff4444; color:white; }
        .btn-delete:hover{ background:#cc0000; }
        
        table{ width:100%; border-collapse:collapse; background:#111; border-radius:20px; overflow:hidden; border:1px solid #222; }
        th, td{ padding:15px; border-bottom:1px solid #222; text-align:left; }
        th{ color:#00ff08; background:#161616; }
        tr:hover{ background:#1a1a1a; }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="logo"><i class="fa-solid fa-shield-halved"></i> BRN ADMIN</div>
    
    <a href="admin.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
    <a href="mensagens.php" style="color:#00ff08; background:#1a1a1a;"><i class="fa-solid fa-envelope"></i> Mensagens</a>
    <a href="projetos.php"><i class="fa-solid fa-image"></i> Projetos</a>
    <a href="index.php"><i class="fa-solid fa-globe"></i> Ver Site</a>
    <a href="logout.php" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
</div>

    <h1 style="color:#00ff08; margin-bottom:20px;">Mensagens Recebidas</h1>
    
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Celular</th>
                <th>Mensagem</th>
                <th>Data</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "
                    <tr>
                        <td>{$row['nome']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['celular']}</td>
                        <td style='max-width: 200px;'>{$row['mensagem']}</td>
                        <td>{$row['data_envio']}</td>
                        <td>
                            <a href='deletar.php?id={$row['id']}' class='btn-deletar'>
                                <button class='btn btn-delete'><i class='fa-solid fa-trash'></i> Excluir</button>
                            </a>
                        </td>
                    </tr>
                    ";
                }
            }else{
                echo "<tr><td colspan='6' style='text-align:center; padding: 30px;'>Nenhuma mensagem encontrada</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.btn-deletar').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const urlDestino = this.getAttribute('href');

            Swal.fire({
                title: 'Tem certeza?',
                text: "Esta mensagem será apagada definitivamente!",
                icon: 'warning',
                showCancelButton: true,
                background: '#111',
                color: '#fff',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = urlDestino;
                }
            });
        });
    });

    // Toast de confirmação
    <?php
    if (isset($_SESSION['status_admin'])) {
        $icon = $_SESSION['status_admin']['icon'];
        $title = $_SESSION['status_admin']['title'];
        echo "
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                background: '#111',
                color: '#fff'
            });
            Toast.fire({ icon: '$icon', title: '$title' });
        </script>
        ";
        unset($_SESSION['status_admin']);
    }
    ?>
</script>

</body>
</html>
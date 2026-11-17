<?php
session_start();

$conn = new mysqli("localhost", "root", "", "bancodedados");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$sql = "SELECT * FROM projetos ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Projetos</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#0a0a0a;
            color:white;
            font-family:Arial;
            display:flex;
        }

        /* MENU */
        .sidebar{
            width:250px;
            height:100vh;
            background:#111;
            padding:30px;
            position:fixed;
        }

        .logo{
            color:#00ff08;
            font-size:28px;
            margin-bottom:40px;
            font-weight:bold;
        }

        .sidebar a{
            display:block;
            color:#ccc;
            text-decoration:none;
            margin:20px 0;
            transition:.3s;
        }

        .sidebar a:hover{
            color:#00ff08;
            transform:translateX(5px);
        }

        .sidebar i{
            margin-right:10px;
        }

        /* CONTEÚDO */
        .main{
            margin-left:250px;
            width:100%;
            padding:30px;
        }

        .header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        h1{
            color:#00ff08;
        }

        /* GRID */
        .grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
            gap:25px;
        }

        /* CARD */
        .card{
            background:#111;
            border-radius:20px;
            overflow:hidden;
            border:1px solid #1f1f1f;
            transition:.3s;
        }

        .card:hover{
            transform:translateY(-5px);
            box-shadow:0 0 20px #00ff08;
        }

        .card img{
            width:100%;
            height:220px;
            object-fit:cover;
        }

        .card-content{
            padding:20px;
        }

        .card h2{
            color:#00ff08;
            margin-bottom:10px;
        }

        .card p{
            color:#ccc;
            margin-bottom:20px;
        }

        /* BOTÕES */
        .btn{
            display:inline-block;
            padding:12px 18px;
            border-radius:10px;
            text-decoration:none;
            font-weight:bold;
            transition:.3s;
            border: none;
            cursor: pointer;
        }

        .ver{
            background:#00ff08;
            color:black;
        }

        .excluir{
            background:red;
            color:white;
            margin-left:10px;
        }

        .btn:hover{
            transform:scale(1.05);
        }

        .btn-adicionar{
            background:#00ff08;
            color:black;
            padding:12px 25px;
            border:none;
            border-radius:10px;
            font-weight:bold;
            cursor:pointer;
            transition:.3s;
        }

        .btn-adicionar:hover{
            background:#00cc06;
            transform:scale(1.05);
        }

        /* MODAL */
        .modal{
            display:none;
            position:fixed;
            z-index:999;
            left:0;
            top:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.8);
            backdrop-filter:blur(5px);
        }

        .modal-content{
            background:#111;
            margin:5% auto;
            padding:30px;
            border:1px solid #00ff08;
            border-radius:20px;
            width:90%;
            max-width:500px;
            position:relative;
            animation:slideIn .3s ease;
        }

        @keyframes slideIn{
            from{transform:translateY(-50px); opacity:0;}
            to{transform:translateY(0); opacity:1;}
        }

        .close{
            color:#fff;
            float:right;
            font-size:28px;
            font-weight:bold;
            cursor:pointer;
            transition:.3s;
        }

        .close:hover{
            color:#00ff08;
        }

        .modal h2{
            color:#00ff08;
            margin-bottom:20px;
        }

        .modal form{
            display:flex;
            flex-direction:column;
            gap:15px;
        }

        .modal input,
        .modal textarea{
            background:#1b1b1b;
            border:1px solid #333;
            padding:15px;
            border-radius:10px;
            color:white;
            width:100%;
            font-family:Arial;
        }

        .modal input:focus,
        .modal textarea:focus{
            border-color:#00ff08;
            outline:none;
        }

        .modal textarea{
            height:100px;
            resize:vertical;
        }

        .modal button[type="submit"]{
            background:#00ff08;
            color:black;
            padding:15px;
            border:none;
            border-radius:10px;
            font-weight:bold;
            cursor:pointer;
            transition:.3s;
        }

        .modal button[type="submit"]:hover{
            background:#00cc06;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="logo">BRN ADMIN</div>

    <a href="admin.php">
        <i class="fa-solid fa-chart-line"></i> Dashboard
    </a>

    <a href="mensagens.php">
        <i class="fa-solid fa-envelope"></i> Mensagens
    </a>

    <a href="projetos.php" style="color:#00ff08; background:#1a1a1a; padding:10px; border-radius:8px;">
        <i class="fa-solid fa-image"></i> Projetos
    </a>

    <a href="index.php">
        <i class="fa-solid fa-globe"></i> Ver Site
    </a>
</div>

<div class="main">
    <div class="header">
        <h1>Projetos Cadastrados</h1>
        <button class="btn-adicionar" id="btnAbrirModal">
            <i class="fa-solid fa-plus"></i> Adicionar Projeto
        </button>
    </div>

    <div class="grid">
    <?php
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "
            <div class='card'>
                <img src='{$row['imagem']}'>
                <div class='card-content'>
                    <h2>{$row['nome']}</h2>
                    <p>{$row['descricao']}</p>
                    
                    <a href='{$row['link']}' target='_blank' class='btn ver'>
                        Ver Projeto
                    </a>

                    <a href='deletar_projeto.php?id={$row['id']}' class='btn excluir btn-deletar-projeto'>
                        Excluir
                    </a>
                </div>
            </div>
            ";
        }
    }else{
        echo "<p style='color:#ccc; grid-column:1/-1; text-align:center; padding:50px;'>Nenhum projeto cadastrado. Clique em 'Adicionar Projeto' para começar.</p>";
    }
    ?>
    </div>
</div>

<!-- MODAL -->
<div id="modalProjeto" class="modal">
    <div class="modal-content">
        <span class="close" id="btnFecharModal">&times;</span>
        <h2>Adicionar Novo Projeto</h2>
        <form action="salvar_projeto.php" method="POST">
            <input type="text" name="nome" placeholder="Nome do projeto" required>
            <input type="text" name="link" placeholder="Link do projeto (ex: https://...)" required>
            <input type="text" name="imagem" placeholder="Nome da imagem (ex: projeto1.jpg)" required>
            <textarea name="descricao" placeholder="Descrição do projeto" required></textarea>
            <button type="submit">
                <i class="fa-solid fa-save"></i> Salvar Projeto
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Abrir Modal
    const modal = document.getElementById('modalProjeto');
    const btnAbrir = document.getElementById('btnAbrirModal');
    const btnFechar = document.getElementById('btnFecharModal');

    btnAbrir.onclick = () => {
        modal.style.display = 'block';
    }

    btnFechar.onclick = () => {
        modal.style.display = 'none';
    }

    window.onclick = (event) => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    // Confirmação de Exclusão
    document.querySelectorAll('.btn-deletar-projeto').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const urlDestino = this.getAttribute('href');

            Swal.fire({
                title: 'Excluir Projeto?',
                text: "O projeto será deletado permanentemente do seu portfólio!",
                icon: 'warning',
                showCancelButton: true,
                background: '#111',
                color: '#fff',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = urlDestino;
                }
            });
        });
    });
</script>

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
            color: '#fff',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: '$icon',
            title: '$title'
        });
    </script>
    ";

    unset($_SESSION['status_admin']);
}
?>

</body>
</html>
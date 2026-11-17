<?php 
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 0); 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRN - Transformando Ideias</title>
    <meta name="description" content="BRN - Desenvolvimento Web, Mobile e Design.">
    
    <!-- Fontes e Ícones -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="style.css">

    <style>
        :root { --a11y-font-size: 100%; --cor-primaria: #00ff08; --cor-bg: #111; --cor-text: #fff; }
        body { font-size: var(--a11y-font-size); transition: font-size 0.3s ease; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; background: var(--cor-bg); color: var(--cor-text); }
        
        /* Alto Contraste */
        body.high-contrast { background: #000 !important; color: #fff !important; }
        body.high-contrast header, body.high-contrast main, body.high-contrast footer { background: #000 !important; }
        body.high-contrast h1, body.high-contrast h2, body.high-contrast h3, body.high-contrast p, body.high-contrast li, body.high-contrast a { color: #fff !important; }
        body.high-contrast .btn-contato button, body.high-contrast .btn-enviar input, .a11y-btn { background: #ffff00 !important; color: #000 !important; border: 2px solid #fff !important; }
        body.high-contrast input, body.high-contrast textarea { background: #333 !important; color: #fff !important; border: 1px solid #fff !important; }
        
        /* Links Sublinhados */
        body.underline-links a { text-decoration: underline !important; }
        
        /* Foco Visível */
        *:focus { outline: 3px solid var(--cor-primaria) !important; outline-offset: 2px; }

        /* Botão Acessibilidade */
        .a11y-toggle {
            position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px;
            background: var(--cor-primaria); color: #000; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; font-size: 24px; cursor: pointer;
            z-index: 9999; box-shadow: 0 4px 15px rgba(0,255,8,0.4); border: none; transition: transform 0.3s;
        }
        .a11y-toggle:hover { transform: scale(1.1); }
        .a11y-toggle i { animation: pulse 2s infinite; }
        @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.1); } 100% { transform: scale(1); } }

        /* Painel Acessibilidade */
        .a11y-panel {
            position: fixed; bottom: 90px; right: 20px; background: #111; border: 2px solid var(--cor-primaria);
            border-radius: 15px; padding: 20px; width: 250px; z-index: 9998; display: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.8);
        }
        .a11y-panel.active { display: block; animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .a11y-title { color: var(--cor-primaria); font-size: 18px; margin-bottom: 15px; font-weight: bold; display: flex; align-items: center; gap: 10px; }
        .a11y-option { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; color: #fff; font-size: 14px; }
        .a11y-btn { background: #222; border: 1px solid #444; color: #fff; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        .a11y-btn:hover { background: var(--cor-primaria); color: #000; }
        .a11y-close { position: absolute; top: 10px; right: 10px; background: none; border: none; color: #666; font-size: 20px; cursor: pointer; }
        .a11y-close:hover { color: #fff; }

        /* Botão Voltar ao Topo */
        #btn-topo {
            position: fixed; bottom: 20px; left: 20px; width: 50px; height: 50px;
            background: var(--cor-primaria); color: #000; border-radius: 50%; display: none;
            align-items: center; justify-content: center; font-size: 20px; cursor: pointer;
            z-index: 9998; box-shadow: 0 4px 10px rgba(0,0,0,0.5); border: none; transition: 0.3s;
        }
        .menu-mobile-btn, .menu-mobile-overlay { display: none !important; }
        .interface { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        
        @media (max-width: 768px) {
            .menu-desktop { display: none !important; }
            .menu-mobile-btn { display: block !important; font-size: 28px; color: white; cursor: pointer; z-index: 1001; margin-left: auto; }
            .menu-mobile-overlay { display: flex !important; position: fixed; top: 0; left: -100%; width: 80%; max-width: 300px; height: 100vh; background: #111; z-index: 1000; transition: 0.4s; flex-direction: column; padding: 80px 30px 30px; box-shadow: 5px 0 15px rgba(0,0,0,0.5); }
            .menu-mobile-overlay.active { left: 0; }
            .menu-mobile-overlay a { color: white; text-decoration: none; font-size: 20px; margin: 15px 0; padding: 10px; border-bottom: 1px solid #222; transition: 0.3s; }
            .menu-mobile-overlay a:hover { color: var(--cor-primaria); padding-left: 15px; }
            .close-menu { position: absolute; top: 20px; right: 20px; font-size: 30px; color: white; cursor: pointer; background: none; border: none; }
            .btn-contato { display: none; }
            .proj-card-swiper { display: block; transition: transform 0.3s ease, box-shadow 0.3s ease; border-radius: 15px; overflow: hidden; }
            .proj-card-swiper:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0, 255, 8, 0.25); }
        }
        .admin-link { margin-left: 15px; color: #666; transition: 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
        .admin-link:hover { color: var(--cor-primaria); }
    </style>
</head>
<body>

<!-- Botão Acessibilidade -->
<button class="a11y-toggle" onclick="toggleA11y()" aria-label="Opções de acessibilidade">
    <i class="fa-solid fa-universal-access"></i>
</button>

<!-- Painel Acessibilidade -->
<div class="a11y-panel" id="a11yPanel" role="dialog" aria-labelledby="a11yTitle">
    <button class="a11y-close" onclick="toggleA11y()" aria-label="Fechar painel">&times;</button>
    <div class="a11y-title" id="a11yTitle"><i class="fa-solid fa-universal-access"></i> Acessibilidade</div>
    <div class="a11y-option"><span>Aumentar Fonte</span><button class="a11y-btn" onclick="adjustFont(1)" aria-label="Aumentar fonte"><i class="fa-solid fa-plus"></i></button></div>
    <div class="a11y-option"><span>Diminuir Fonte</span><button class="a11y-btn" onclick="adjustFont(-1)" aria-label="Diminuir fonte"><i class="fa-solid fa-minus"></i></button></div>
    <div class="a11y-option"><span>Alto Contraste</span><button class="a11y-btn" onclick="toggleContrast()" aria-label="Ativar alto contraste"><i class="fa-solid fa-adjust"></i></button></div>
    <div class="a11y-option"><span>Sublinhar Links</span><button class="a11y-btn" onclick="toggleUnderline()" aria-label="Sublinhar links"><i class="fa-solid fa-underline"></i></button></div>
    <div class="a11y-option"><span>Resetar</span><button class="a11y-btn" onclick="resetA11y()" style="background:#444;" aria-label="Resetar"><i class="fa-solid fa-rotate-left"></i></button></div>
</div>

<!-- Botão Voltar ao Topo -->
<button id="btn-topo" onclick="scrollToTop()" aria-label="Voltar ao topo">
    <i class="fa-solid fa-arrow-up"></i>
</button>

<header>
    <div class="interface">
        <div class="logo"><a href="#" aria-label="BRN"><img src="images/logo.png?v=20261028" alt="Logo BRN" onerror="this.src='images/logo-padrao.png'"></a></div>
        <div class="menu-mobile-btn" onclick="toggleMenu()" aria-label="Abrir menu"><i class="fa-solid fa-bars"></i></div>
        <nav class="menu-desktop" aria-label="Menu principal">
            <ul>
                <li><a href="#inicio"><i class="fa-solid fa-house"></i> Início</a></li>
                <li><a href="#especialidades"><i class="fa-regular fa-address-card"></i> Especialidades</a></li>
                <li><a href="#sobre"><i class="fa-solid fa-circle-info"></i> Sobre</a></li>
                <li><a href="#projetos"><i class="fa-regular fa-lightbulb"></i> Projetos</a></li>
            </ul>
        </nav>
        <?php if(isset($_SESSION['admin_autenticado']) && $_SESSION['admin_autenticado'] === true): ?>
            <a href="admin.php" class="admin-link" style="background: #00ff08; color: black; padding: 8px 15px; border-radius: 5px; font-weight: bold; font-size: 14px;"><i class="fa-solid fa-lock"></i> Painel</a>
        <?php else: ?>
            <a href="login.php" class="admin-link" aria-label="Área administrativa"><i class="fa-solid fa-lock"></i></a>
        <?php endif; ?>
               <div class="btn-contato"><a href="#contato"><button><i class="fa-solid fa-envelope"></i> Contato</button></a></div>
</header>

<div class="menu-mobile-overlay" id="mobileMenu" role="dialog" aria-modal="true">
    <button class="close-menu" onclick="toggleMenu()" aria-label="Fechar menu">&times;</button>
    <a href="#inicio" onclick="toggleMenu()">Início</a>
    <a href="#especialidades" onclick="toggleMenu()">Especialidades</a>
    <a href="#sobre" onclick="toggleMenu()">Sobre</a>
    <a href="#projetos" onclick="toggleMenu()">Projetos</a>
    <a href="login.php" onclick="toggleMenu()">Login Admin</a>
    <a href="#contato" onclick="toggleMenu()">Contato</a></div>

<main>
    <section class="topo-do-site" id="inicio">
        <div class="interface">
            <div class="flex">
                <div class="txt-topo-site">
                    <h1>TRANSFORMANDO IDEIAS EM<br>REALIDADE DIGITAL<span>.</span></h1>
                    <p>Criatividade e inovação andam lado a lado. Com uma combinação única de design impactante, funcionalidade intuitiva e otimização para resultados, estou pronto para criar a presença online dos seus sonhos.</p>
                    <div class="btn-contato"><a href="https://wa.me/19996293016" target="_blank" rel="noopener noreferrer"><button><i class="fa-brands fa-whatsapp"></i> Entre em contato</button></a></div>
                </div>
                <div class="img-topo-site"><img src="images/pessoa.png" alt="Foto do Bruno" loading="lazy" onerror="this.src='images/pessoa-padrao.png'"></div>
            </div>
        </div>
    </section>

    <section class="Especialidades" id="especialidades">
        <div class="interface">
            <h2>MINHAS <span>ESPECIALIDADES</span></h2>
            <div class="flex">
                <div class="Especialidades-box"><i class="fa-solid fa-code"></i><h3>Web</h3><p>Criação de sites modernos e responsivos.</p></div>
                <div class="Especialidades-box"><i class="fa-solid fa-mobile-screen"></i><h3>Mobile</h3><p>Aplicações para dispositivos móveis.</p></div>
                <div class="Especialidades-box"><i class="fa-solid fa-palette"></i><h3>Design</h3><p>Interfaces bonitas e intuitivas.</p></div>
            </div>
        </div>
    </section>

    <section class="sobre" id="sobre">
        <div class="interface">
            <div class="flex">
                <div class="img-sobre"><img src="images/foto.png" alt="Foto do Bruno" loading="lazy" onerror="this.src='images/foto-padrao.png'"></div>
                <div class="txt-sobre">
                    <h2>MUITO PRAZER,<br><span>SOU BRUNO</span></h2>
                    <p>Sou desenvolvedor web com foco em criar sites modernos, responsivos e funcionais.</p>
                    <div class="btn-social">
                        <a href="https://instagram.com/seuusuario" target="_blank" rel="noopener noreferrer"><button aria-label="Instagram"><i class="fa-brands fa-instagram"></i></button></a>
                        <a href="https://github.com/seuusuario" target="_blank" rel="noopener noreferrer"><button aria-label="GitHub"><i class="fa-brands fa-github"></i></button></a>
                        <a href="https://linkedin.com/in/seuusuario" target="_blank" rel="noopener noreferrer"><button aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></button></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <?php
// Inclui a conexão PDO
require_once 'config.php';
?>

<section class="projetos" id="projetos">
    <div class="interface">
        <h2>MEUS <span>PROJETOS</span></h2>
        
        <!-- Container do Swiper -->
        <div class="swiper myProjectsSwiper">
            <div class="swiper-wrapper">
                <?php
                try {
                    // 1. PREPARED STATEMENT (Segurança)
                    $stmt = $pdo->query("SELECT nome, link, imagem, descricao FROM projetos ORDER BY id DESC");
                    $projetos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($projetos) > 0) {
                        foreach ($projetos as $projeto) {
                            // Sanitização de saída
                            $nome = htmlspecialchars($projeto['nome'], ENT_QUOTES, 'UTF-8');
                            $link = htmlspecialchars($projeto['link'], ENT_QUOTES, 'UTF-8');
                            $descricao = htmlspecialchars($projeto['descricao'] ?? 'Projeto desenvolvido com foco em performance e design.', ENT_QUOTES, 'UTF-8');
                            
                            // Lógica de imagem com fallback
                            $imagem = !empty($projeto['imagem']) ? htmlspecialchars($projeto['imagem']) : 'images/imagem-padrao.jpg';
                            ?>
                            
                            <div class="swiper-slide">
                                <div class="proj-card-modern">
                                    <div class="card-img-wrapper">
                                        <img src="<?= $imagem ?>" alt="Print do projeto <?= $nome ?>" loading="lazy" onerror="this.src='images/imagem-padrao.jpg'">
                                        <div class="card-overlay">
                                            <p class="proj-desc"><?= $descricao ?></p>
                                            <a href="<?= $link ?>" target="_blank" rel="noopener noreferrer" class="btn-ver-projeto">
                                                Ver Projeto <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-info">
                                        <h3><?= $nome ?></h3>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    } else {
                        // Placeholders se não houver projetos
                        echo "
                        <div class='swiper-slide'>
                            <div class='proj-card-modern placeholder'>
                                <div class='placeholder-content'>
                                    <i class='fa-solid fa-rocket'></i>
                                    <h3>Em Breve</h3>
                                    <p>novos projetos serão lançados</p>
                                </div>
                            </div>
                        </div>";
                    }
                } catch (PDOException $e) {
                    // Tratamento de erro elegante
                    echo "<div class='swiper-slide'><div class='proj-card-modern placeholder'><div class='placeholder-content'><i class='fa-solid fa-triangle-exclamation'></i><h3>Erro</h3><p>Indisponível no momento.</p></div></div></div>";
                }
                ?>
            </div>
            
            <!-- Controles -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next" aria-label="Próximo projeto"></div>
            <div class="swiper-button-prev" aria-label="Projeto anterior"></div>
        </div>
    </div>
</section>

    <section class="feedbacks" id="feedbacks">
        <div class="interface">
            <h2 style="color:white;">FEED<span style="color:#00ff08;">BACKS</span></h2>
            <form action="salvar_feedback.php" method="POST" aria-label="Formulário de feedback">
                <input type="text" name="nome" placeholder="Seu nome" required aria-label="Seu nome">
                <textarea name="mensagem" placeholder="Digite seu feedback" required aria-label="Sua mensagem"></textarea>
                <div class="btn-enviar"><input type="submit" value="ENVIAR FEEDBACK" aria-label="Enviar feedback"></div>
            </form>
            <div class="feedback-container">
            <?php
            $conn = new mysqli("localhost", "root", "", "bancodedados");
            if ($conn->connect_error) {
                echo "<p style='color:white;'>Nenhum feedback disponível.</p>";
            } else {
                $sql = "SELECT nome, mensagem FROM feedbacks ORDER BY id DESC LIMIT 10";
                $result = $conn->query($sql);
                if($result && $result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $nome_seguro = htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8');
                        $mensagem_segura = htmlspecialchars($row['mensagem'], ENT_QUOTES, 'UTF-8');
                        echo "<div class='feedback-box'><i class='fa-solid fa-user'></i><h3 style='color:white;'>$nome_seguro</h3><p style='color:white;'>$mensagem_segura</p></div>";
                    }
                } else {
                    echo "<p style='color:white;'>Seja o primeiro a deixar um feedback!</p>";
                }
                $conn->close();
            }
            ?>
            </div>
        </div>
    </section>

    <section class="contato" id="contato">
        <div class="interface">
            <h2><span>FALA</span> COMIGO</h2>
            <p class="subtitulo">Vamos tirar suas ideias do papel</p>
            <form action="enviar.php" method="POST" aria-label="Formulário de contato">
                <input type="text" name="nome" placeholder="Seu nome:" required aria-label="Seu nome">
                <input type="email" name="email" placeholder="Seu e-mail:" required aria-label="Seu e-mail">
                <input type="text" name="celular" placeholder="Seu celular:" aria-label="Seu celular">
                <textarea name="mensagem" placeholder="Sua mensagem:" required aria-label="Sua mensagem"></textarea>
                <div class="btn-enviar"><input type="submit" value="ENVIAR" aria-label="Enviar mensagem"></div>
            </form>
        </div>
    </section>
</main>

<footer>
    <div class="interface">
        <div class="flex">
            <div class="logo-footer"><h2>BRN</h2></div>
            <div class="social-footer">
                <a href="https://youtube.com/seuusuario" target="_blank" rel="noopener noreferrer"><button aria-label="YouTube"><i class="fa-brands fa-youtube"></i></button></a>
                <a href="https://instagram.com/seuusuario" target="_blank" rel="noopener noreferrer"><button aria-label="Instagram"><i class="fa-brands fa-instagram"></i></button></a>
                <a href="https://linkedin.com/in/seuusuario" target="_blank" rel="noopener noreferrer"><button aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></button></a>
            </div>
        </div>
        <div class="linha"></div>
        <p class="email"><i class="fa-solid fa-envelope"></i> contato@bruno.com.br</p>
    </div>
</footer>

<!-- Scripts JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // --- LÓGICA DE ACESSIBILIDADE ---
    function toggleA11y() {
        document.getElementById('a11yPanel').classList.toggle('active');
    }

    function adjustFont(amount) {
        let currentSize = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--a11y-font-size')) || 100;
        let newSize = currentSize + (amount * 10);
        if (newSize < 80) newSize = 80;
        if (newSize > 150) newSize = 150;
        document.documentElement.style.setProperty('--a11y-font-size', newSize + '%');
    }

    function toggleContrast() {
        document.body.classList.toggle('high-contrast');
    }

    function toggleUnderline() {
        document.body.classList.toggle('underline-links');
    }

    function resetA11y() {
    document.documentElement.style.setProperty('--a11y-font-size', '100%');
    document.body.classList.remove('high-contrast');
    document.body.classList.remove('underline-links');
}

// --- LÓGICA DO MENU MOBILE ---
function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('active');
}

// --- BOTÃO VOLTAR AO TOPO ---
const btnTopo = document.getElementById('btn-topo');
window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
        btnTopo.style.display = 'flex';
    } else {
        btnTopo.style.display = 'none';
    }
});

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// --- INICIALIZAÇÃO DO SWIPER ---
var swiper = new Swiper(".myProjectsSwiper", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    coverflowEffect: { rotate: 0, stretch: 0, depth: 100, modifier: 1, slideShadows: true },
    pagination: { el: ".swiper-pagination", clickable: true },
    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    breakpoints: {
        640: { slidesPerView: 1, spaceBetween: 20 },
        768: { slidesPerView: 2, spaceBetween: 40 },
        1024: { slidesPerView: 3, spaceBetween: 50 }
    },
    loop: true,
    autoplay: { delay: 3000, disableOnInteraction: false }
});

// --- NOTIFICAÇÕES SWEETALERT (ENVIO DE FORMULÁRIO) ---
<?php if (isset($_SESSION['status_envio'])): ?>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    Toast.fire({
        icon: '<?php echo $_SESSION['status_envio']['icon']; ?>',
        title: '<?php echo $_SESSION['status_envio']['title']; ?>'
    });
    <?php unset($_SESSION['status_envio']); ?>
<?php endif; ?>
</script>

<!-- Widget vLibras -->
<div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
        <div class="vw-plugin-top-wrapper"></div>
    </div>
</div>
<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
</script>

</body>
</html>
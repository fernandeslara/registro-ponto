<?php
// Inicia a sessão (necessário para saber se o usuário está logado e qual o tipo dele)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Variáveis úteis para a navbar
$usuarioLogado = isset($_SESSION['usuario_id']);
$nivelAcesso   = $_SESSION['nivel_acesso'] ?? null; // 'admin' ou 'func'
$nomeUsuario   = $_SESSION['nome'] ?? '';

// Define a URL base do projeto automaticamente (funciona em qualquer subpasta do www)
if (!defined('BASE_URL')) {
    // __DIR__ aqui é a pasta "includes". dirname(__DIR__) sobe um nível -> raiz do projeto
    // Normaliza as barras ANTES de comparar (no Windows, __DIR__ usa \ e o DOCUMENT_ROOT usa /)
    $raizProjeto  = str_replace('\\', '/', dirname(__DIR__));
    $documentRoot = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'], '/'));
    $caminhoBase  = str_replace($documentRoot, '', $raizProjeto);
    define('BASE_URL', $caminhoBase);
}

// URL base da API (pasta api/ na raiz do projeto), usada pelas chamadas fetch no JS
if (!defined('API_URL')) {
    define('API_URL', BASE_URL . '/api');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Ponto</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ícones (opcional, usado em alguns botões) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS personalizado -->
    <link href="<?= BASE_URL ?>/css/custom.css" rel="stylesheet">

    <!-- Disponibiliza a URL base da API para os scripts JS -->
    <script>
        window.API_URL = "<?= API_URL ?>";
        window.BASE_URL = "<?= BASE_URL ?>";
    </script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/registro-ponto/index.php">
            <i class="bi bi-clock-history"></i> Registro de Ponto
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <?php if ($usuarioLogado): ?>

                    <?php if ($nivelAcesso === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/funcionarios.php">Funcionários</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/histprocp.php">Histórico</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/relatorios.php">Relatórios</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/registro-ponto/index.php">Bater Ponto</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/funcionario/historico.php">Meus Pontos</a></li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <span class="nav-link text-light-50">
                            <i class="bi bi-person-circle"></i> <?= htmlspecialchars($nomeUsuario) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm ms-lg-2" href="<?= BASE_URL ?>/registro-ponto/logout.php">Sair</a>
                    </li>

                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/registro-ponto/sobre.php">Sobre</a></li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm ms-lg-2" href="<?= BASE_URL ?>/registro-ponto/login.php">Entrar</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<!-- Conteúdo principal -->
<main class="container py-4">
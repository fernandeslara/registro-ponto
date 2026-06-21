<?php
/**
 * auth.php — Proteção de páginas
 *
 * Como usar: inclua esse arquivo NO TOPO de qualquer página que precise
 * de autenticação, ANTES do header.php.
 *
 * Exemplos:
 *
 * Qualquer usuário logado:
 *   require_once __DIR__ . '/../includes/auth.php';
 *   exigirLogin();
 *
 * Só admin:
 *   require_once __DIR__ . '/../includes/auth.php';
 *   exigirAdmin();
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Calcula BASE_URL (necessário para o redirecionamento)
if (!defined('BASE_URL')) {
    $raizProjeto  = str_replace('\\', '/', dirname(__DIR__));
    $documentRoot = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'], '/'));
    define('BASE_URL', str_replace($documentRoot, '', $raizProjeto));
}

/**
 * Redireciona pro login se o usuário não estiver autenticado.
 */
function exigirLogin() {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . '/registro-ponto/login.php');
        exit;
    }
}

/**
 * Redireciona pro login se não for admin.
 */
function exigirAdmin() {
    exigirLogin();
    if (($_SESSION['nivel_acesso'] ?? '') !== 'admin') {
        // Funcionário tentando acessar área admin → manda pra tela de ponto
        header('Location: ' . BASE_URL . '/registro-ponto/index.php');
        exit;
    }
}
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Calcula a BASE_URL (mesmo cálculo usado no header.php)
$raizProjeto  = str_replace('\\', '/', dirname(__DIR__));
$documentRoot = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'], '/'));
$caminhoBase  = str_replace($documentRoot, '', $raizProjeto);
define('BASE_URL', $caminhoBase);

// Encerra todos os dados da sessão
$_SESSION = [];
session_destroy();

// Redireciona para o login
header('Location: ' . BASE_URL . '/registro-ponto/login.php');
exit;
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Calcula a BASE_URL (mesmo cálculo usado no header.php)
$raizProjeto  = str_replace('\\', '/', dirname(__DIR__));
$documentRoot = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'], '/'));
$caminhoBase  = str_replace($documentRoot, '', $raizProjeto);
define('BASE_URL', $caminhoBase);

// TODO: verificar se o usuário logado é admin antes de permitir a exclusão
// if (($_SESSION['tipo'] ?? null) !== 'admin') {
//     header('Location: ' . BASE_URL . '/registro-ponto/login.php');
//     exit;
// }

$id = $_GET['id'] ?? null;

if ($id) {
    // TODO: quando o conexao.php estiver pronto, executar a exclusão real no banco
    // require_once __DIR__ . '/../includes/conexao.php';
    // $stmt = $conexao->prepare("DELETE FROM funcionarios WHERE id = ?");
    // $stmt->bind_param("i", $id);
    // $stmt->execute();

    // Por enquanto, apenas simula a exclusão e redireciona com uma mensagem
    $_SESSION['mensagem'] = "Funcionário #$id excluído com sucesso (simulação — banco ainda não conectado).";
} else {
    $_SESSION['mensagem'] = "Nenhum funcionário selecionado para exclusão.";
}

header('Location: ' . BASE_URL . '/admin/funcionarios.php');
exit;
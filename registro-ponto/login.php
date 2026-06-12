<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Calcula a BASE_URL (mesmo cálculo usado no header.php)
$raizProjeto  = str_replace('\\', '/', dirname(__DIR__));
$documentRoot = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'], '/'));
$caminhoBase  = str_replace($documentRoot, '', $raizProjeto);
define('BASE_URL', $caminhoBase);

require_once __DIR__ . '/../includes/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === '' || $senha === '') {
        $erro = 'Preencha e-mail e senha.';
    } else {
        // AJUSTE: troque "funcionarios" e os nomes das colunas (id, nome, senha, tipo)
        // de acordo com a tabela real do seu banco.sql
        $stmt = $conexao->prepare("SELECT id, nome, senha, tipo FROM funcionarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($usuario = $resultado->fetch_assoc()) {
            // AJUSTE: se as senhas no banco NÃO estiverem com password_hash(),
            // troque por: if ($senha === $usuario['senha'])
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nome']       = $usuario['nome'];
                $_SESSION['tipo']       = $usuario['tipo'];

                $destino = ($usuario['tipo'] === 'admin')
                    ? BASE_URL . '/admin/dashboard.php'
                    : BASE_URL . '/registro-ponto/index.php';

                header('Location: ' . $destino);
                exit;
            } else {
                $erro = 'E-mail ou senha incorretos.';
            }
        } else {
            $erro = 'E-mail ou senha incorretos.';
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="bi bi-clock-history" style="font-size: 2.5rem; color: #1F3A5F;"></i>
                <h4 class="mt-2 mb-0">Acessar o Sistema</h4>
                <small class="text-muted">Informe seus dados para continuar</small>
            </div>

            <?php if ($erro): ?>
                <div class="alert alert-danger py-2">
                    <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>/registro-ponto/sobre.php" class="text-decoration-none small">
                    Sobre o sistema
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php
include __DIR__ . '/../includes/header.php';

// TODO: quando o banco estiver pronto, buscar o funcionário pelo ID recebido via GET
// $id = $_GET['id'] ?? null;
// Por enquanto, usamos um funcionário de exemplo para montar o formulário.
$funcionario = [
    'id'     => $_GET['id'] ?? '',
    'nome'   => 'Ana Souza',
    'email'  => 'ana.souza@empresa.com',
    'cargo'  => 'Analista',
    'status' => 'Ativo',
];

$modoEdicao = !empty($funcionario['id']);
?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-7">

        <h3 class="mb-4">
            <i class="bi bi-person-<?= $modoEdicao ? 'gear' : 'plus' ?>"></i>
            <?= $modoEdicao ? 'Editar Funcionário' : 'Novo Funcionário' ?>
        </h3>

        <div class="card">
            <div class="card-body p-4">
                <!-- TODO: trocar o "action" para o arquivo PHP que vai processar o salvamento no banco -->
                <form method="POST" action="">

                    <?php if ($modoEdicao): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($funcionario['id']) ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required
                               value="<?= htmlspecialchars($funcionario['nome']) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required
                               value="<?= htmlspecialchars($funcionario['email']) ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cargo" class="form-label">Cargo</label>
                            <input type="text" class="form-control" id="cargo" name="cargo"
                                   value="<?= htmlspecialchars($funcionario['cargo']) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="Ativo"   <?= $funcionario['status'] === 'Ativo'   ? 'selected' : '' ?>>Ativo</option>
                                <option value="Inativo" <?= $funcionario['status'] === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                            </select>
                        </div>
                    </div>

                    <?php if (!$modoEdicao): ?>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha de acesso</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                            <small class="text-muted">O funcionário poderá alterá-la depois.</small>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= BASE_URL ?>/admin/funcionarios.php" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Salvar
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php
include __DIR__ . '/../includes/header.php';

// TODO: substituir pelos dados reais vindos do banco (tabela de funcionários)
$funcionarios = [
    ['id' => 1, 'nome' => 'Ana Souza',    'email' => 'ana.souza@empresa.com',    'cargo' => 'Analista',     'status' => 'Ativo'],
    ['id' => 2, 'nome' => 'Carlos Lima',  'email' => 'carlos.lima@empresa.com',  'cargo' => 'Desenvolvedor', 'status' => 'Ativo'],
    ['id' => 3, 'nome' => 'Maria Pereira','email' => 'maria.pereira@empresa.com','cargo' => 'Designer',      'status' => 'Inativo'],
];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="bi bi-people"></i> Funcionários</h3>
    <a href="<?= BASE_URL ?>/admin/cadastrar.php" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Novo Funcionário
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Cargo</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($funcionarios)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Nenhum funcionário cadastrado.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($funcionarios as $f): ?>
                            <tr>
                                <td><?= $f['id'] ?></td>
                                <td><?= htmlspecialchars($f['nome']) ?></td>
                                <td><?= htmlspecialchars($f['email']) ?></td>
                                <td><?= htmlspecialchars($f['cargo']) ?></td>
                                <td>
                                    <?php if ($f['status'] === 'Ativo'): ?>
                                        <span class="badge text-bg-success">Ativo</span>
                                    <?php else: ?>
                                        <span class="badge text-bg-secondary">Inativo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= BASE_URL ?>/admin/editar.php?id=<?= $f['id'] ?>"
                                       class="btn btn-sm btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>/admin/excluir.php?id=<?= $f['id'] ?>"
                                       class="btn btn-sm btn-outline-danger" title="Excluir"
                                       onclick="return confirm('Tem certeza que deseja excluir este funcionário?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
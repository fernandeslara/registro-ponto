<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="bi bi-people"></i> Funcionários</h3>
    <a href="<?= BASE_URL ?>/admin/editar.php" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Novo Funcionário
    </a>
</div>

<!-- Mensagem de feedback (sucesso/erro), preenchida via JavaScript -->
<div id="mensagemFeedback" class="alert d-none"></div>

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
                        <th>Departamento</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody id="corpoTabelaFuncionarios">
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Carregando funcionários...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
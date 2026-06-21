<?php include __DIR__ . '/../includes/header.php'; ?>

<?php
$cpf = $_GET['cpf'] ?? '';
$modoEdicao = !empty($cpf);
?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-7">

        <h3 class="mb-4">
            <i class="bi bi-person-<?= $modoEdicao ? 'gear' : 'plus' ?>"></i>
            <?= $modoEdicao ? 'Editar Funcionário' : 'Novo Funcionário' ?>
        </h3>

        <div id="mensagemFeedbackEditar" class="alert d-none"></div>

        <div class="card">
            <div class="card-body p-4">
                <form id="formEditar">
                    <input type="hidden" id="cpfOriginal" value="<?= htmlspecialchars($cpf) ?>">
                    <input type="hidden" id="modoEdicao" value="<?= $modoEdicao ? '1' : '0' ?>">

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf"
                               <?= $modoEdicao ? 'readonly' : 'required' ?>
                               placeholder="Apenas números">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cargo" class="form-label">Cargo</label>
                            <input type="text" class="form-control" id="cargo" name="cargo">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="departamento" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="departamento" name="departamento">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="horario_entrada" class="form-label">Horário de entrada</label>
                            <input type="time" class="form-control" id="horario_entrada" name="horario_entrada">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="horario_saida" class="form-label">Horário de saída</label>
                            <input type="time" class="form-control" id="horario_saida" name="horario_saida">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nivel_acesso" class="form-label">Nível de acesso</label>
                            <select class="form-select" id="nivel_acesso" name="nivel_acesso">
                                <option value="func">Funcionário</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                        <?php if (!$modoEdicao): ?>
                        <div class="col-md-6 mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                            <small class="text-muted">O funcionário poderá alterá-la depois.</small>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= BASE_URL ?>/admin/funcionarios.php" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary" id="btnSalvar">
                            <i class="bi bi-check-lg"></i> Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
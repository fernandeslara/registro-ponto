<?php include __DIR__ . '/../includes/header.php'; ?>

<h3 class="mb-4"><i class="bi bi-clock-history"></i> Histórico de Pontos</h3>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-body">
        <form id="formFiltroHistAdmin" class="row g-3 align-items-end">
            <div class="col-12 col-md-4">
                <label for="funcionario_id" class="form-label small mb-1">Funcionário</label>
                <select class="form-select" id="funcionario_id" name="funcionario_id">
                    <option value="">Todos</option>
                    <!-- Preenchido via JS -->
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label for="mes" class="form-label small mb-1">Mês</label>
                <select class="form-select" id="mes" name="mes">
                    <?php
                    $meses = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho',
                              'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
                    $mesAtual = (int) date('m');
                    foreach ($meses as $i => $nomeMes):
                        $num = $i + 1;
                    ?>
                        <option value="<?= $num ?>" <?= $num === $mesAtual ? 'selected' : '' ?>>
                            <?= $nomeMes ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label for="ano" class="form-label small mb-1">Ano</label>
                <select class="form-select" id="ano" name="ano">
                    <?php for ($a = (int)date('Y'); $a >= 2024; $a--): ?>
                        <option value="<?= $a ?>" <?= $a === (int)date('Y') ? 'selected' : '' ?>>
                            <?= $a ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<div id="mensagemErroHistAdmin" class="alert alert-danger d-none"></div>

<!-- Tabela -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Entrada</th>
                        <th>Início Intervalo</th>
                        <th>Fim Intervalo</th>
                        <th>Saída</th>
                    </tr>
                </thead>
                <tbody id="corpoTabelaHistAdmin">
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Carregando...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
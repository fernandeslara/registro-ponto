<?php
include __DIR__ . '/../includes/header.php';

// TODO: substituir pelos registros reais do banco, aplicando os filtros recebidos via GET
$registros = [
    ['funcionario' => 'Ana Souza',     'data' => '14/06/2026', 'tipo' => 'Entrada', 'horario' => '08:01'],
    ['funcionario' => 'Ana Souza',     'data' => '14/06/2026', 'tipo' => 'Saída',   'horario' => '17:58'],
    ['funcionario' => 'Carlos Lima',   'data' => '14/06/2026', 'tipo' => 'Entrada', 'horario' => '08:10'],
    ['funcionario' => 'Maria Pereira', 'data' => '13/06/2026', 'tipo' => 'Entrada', 'horario' => '08:05'],
];

// TODO: substituir pela lista real de funcionários do banco (para preencher o <select>)
$listaFuncionarios = ['Ana Souza', 'Carlos Lima', 'Maria Pereira'];

$filtroFuncionario = $_GET['funcionario'] ?? '';
$filtroDataInicio  = $_GET['data_inicio'] ?? '';
$filtroDataFim     = $_GET['data_fim'] ?? '';
?>

<h3 class="mb-4"><i class="bi bi-clock-history"></i> Histórico de Pontos</h3>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-12 col-md-4">
                <label for="funcionario" class="form-label small mb-1">Funcionário</label>
                <select class="form-select" id="funcionario" name="funcionario">
                    <option value="">Todos</option>
                    <?php foreach ($listaFuncionarios as $nomeFunc): ?>
                        <option value="<?= htmlspecialchars($nomeFunc) ?>"
                            <?= $filtroFuncionario === $nomeFunc ? 'selected' : '' ?>>
                            <?= htmlspecialchars($nomeFunc) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <label for="data_inicio" class="form-label small mb-1">De</label>
                <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                       value="<?= htmlspecialchars($filtroDataInicio) ?>">
            </div>
            <div class="col-6 col-md-3">
                <label for="data_fim" class="form-label small mb-1">Até</label>
                <input type="date" class="form-control" id="data_fim" name="data_fim"
                       value="<?= htmlspecialchars($filtroDataFim) ?>">
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabela de registros -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Funcionário</th>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Horário</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Nenhum registro encontrado para os filtros selecionados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['funcionario']) ?></td>
                                <td><?= htmlspecialchars($r['data']) ?></td>
                                <td><?= htmlspecialchars($r['tipo']) ?></td>
                                <td><?= htmlspecialchars($r['horario']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
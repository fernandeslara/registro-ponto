<?php
include __DIR__ . '/../includes/header.php';

// TODO: substituir pelos dados reais calculados a partir do banco
$resumoFuncionarios = [
    ['nome' => 'Ana Souza',     'horas_trabalhadas' => '160h 30min', 'faltas' => 0, 'atrasos' => 1],
    ['nome' => 'Carlos Lima',   'horas_trabalhadas' => '158h 45min', 'faltas' => 1, 'atrasos' => 0],
    ['nome' => 'Maria Pereira', 'horas_trabalhadas' => '152h 10min', 'faltas' => 2, 'atrasos' => 3],
];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="bi bi-bar-chart"></i> Relatórios</h3>
</div>

<!-- Filtro de período do relatório -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-12 col-md-3">
                <label for="mes" class="form-label small mb-1">Mês</label>
                <input type="month" class="form-control" id="mes" name="mes"
                       value="<?= htmlspecialchars($_GET['mes'] ?? date('Y-m')) ?>">
            </div>
            <div class="col-12 col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Gerar
                </button>
            </div>
            <div class="col-12 col-md-3 ms-auto">
                <button type="button" class="btn btn-outline-secondary w-100" onclick="window.print()">
                    <i class="bi bi-printer"></i> Imprimir
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabela resumo por funcionário -->
<div class="card">
    <div class="card-header bg-white">
        <strong>Resumo do período</strong>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Funcionário</th>
                        <th>Horas trabalhadas</th>
                        <th>Faltas</th>
                        <th>Atrasos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($resumoFuncionarios)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Nenhum dado disponível para o período selecionado.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($resumoFuncionarios as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['nome']) ?></td>
                                <td><?= htmlspecialchars($r['horas_trabalhadas']) ?></td>
                                <td>
                                    <?php if ($r['faltas'] > 0): ?>
                                        <span class="badge text-bg-danger"><?= $r['faltas'] ?></span>
                                    <?php else: ?>
                                        <span class="badge text-bg-success">0</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($r['atrasos'] > 0): ?>
                                        <span class="badge text-bg-warning text-dark"><?= $r['atrasos'] ?></span>
                                    <?php else: ?>
                                        <span class="badge text-bg-success">0</span>
                                    <?php endif; ?>
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
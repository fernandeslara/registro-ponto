<?php
include __DIR__ . '/../includes/header.php';

// TODO: substituir pelos dados reais vindos do banco
$totalFuncionarios = 12;
$presentesHoje     = 9;
$ausentesHoje      = 3;
$registrosHoje     = 24;

// TODO: substituir pelos últimos registros vindos do banco
$ultimosRegistros = [
    ['nome' => 'Ana Souza',     'tipo' => 'Entrada', 'horario' => '08:01', 'data' => '14/06/2026'],
    ['nome' => 'Carlos Lima',   'tipo' => 'Saída',   'horario' => '17:58', 'data' => '14/06/2026'],
    ['nome' => 'Maria Pereira', 'tipo' => 'Entrada', 'horario' => '08:15', 'data' => '14/06/2026'],
];
?>

<h3 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h3>

<!-- Cards de resumo -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-people fs-2 text-primary"></i>
                <h4 class="mt-2 mb-0"><?= $totalFuncionarios ?></h4>
                <small class="text-muted">Funcionários</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-check-circle fs-2 text-success"></i>
                <h4 class="mt-2 mb-0"><?= $presentesHoje ?></h4>
                <small class="text-muted">Presentes hoje</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-x-circle fs-2 text-danger"></i>
                <h4 class="mt-2 mb-0"><?= $ausentesHoje ?></h4>
                <small class="text-muted">Ausentes hoje</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-clock-history fs-2 text-info"></i>
                <h4 class="mt-2 mb-0"><?= $registrosHoje ?></h4>
                <small class="text-muted">Registros hoje</small>
            </div>
        </div>
    </div>
</div>

<!-- Últimos registros -->
<div class="card">
    <div class="card-header bg-white">
        <strong>Últimos registros de ponto</strong>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Funcionário</th>
                        <th>Tipo</th>
                        <th>Horário</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ultimosRegistros)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Nenhum registro encontrado.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ultimosRegistros as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['nome']) ?></td>
                                <td><?= htmlspecialchars($r['tipo']) ?></td>
                                <td><?= htmlspecialchars($r['horario']) ?></td>
                                <td><?= htmlspecialchars($r['data']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white text-end">
        <a href="<?= BASE_URL ?>/admin/histprocp.php" class="small text-decoration-none">
            Ver histórico completo <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
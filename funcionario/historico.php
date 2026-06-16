<?php
include __DIR__ . '/../includes/header.php';

// TODO: substituir pelos registros reais do funcionário logado, vindos do banco
// (filtrar por $_SESSION['usuario_id'])
$historico = [
    ['data' => '14/06/2026', 'entrada' => '08:01', 'inicio_intervalo' => '12:00', 'fim_intervalo' => '13:02', 'saida' => '17:58'],
    ['data' => '13/06/2026', 'entrada' => '08:05', 'inicio_intervalo' => '12:10', 'fim_intervalo' => '13:05', 'saida' => '18:00'],
    ['data' => '12/06/2026', 'entrada' => '07:58', 'inicio_intervalo' => '12:00', 'fim_intervalo' => '13:00', 'saida' => '17:55'],
];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="bi bi-calendar-check"></i> Meus Pontos</h3>
</div>

<!-- Filtro por período -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-auto">
                <label for="data_inicio" class="form-label small mb-1">De</label>
                <input type="date" class="form-control" id="data_inicio" name="data_inicio"
                       value="<?= htmlspecialchars($_GET['data_inicio'] ?? '') ?>">
            </div>
            <div class="col-auto">
                <label for="data_fim" class="form-label small mb-1">Até</label>
                <input type="date" class="form-control" id="data_fim" name="data_fim"
                       value="<?= htmlspecialchars($_GET['data_fim'] ?? '') ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabela de histórico -->
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
                <tbody>
                    <?php if (empty($historico)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Nenhum registro encontrado para o período selecionado.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($historico as $dia): ?>
                            <tr>
                                <td><?= htmlspecialchars($dia['data']) ?></td>
                                <td><?= htmlspecialchars($dia['entrada']) ?></td>
                                <td><?= htmlspecialchars($dia['inicio_intervalo']) ?></td>
                                <td><?= htmlspecialchars($dia['fim_intervalo']) ?></td>
                                <td><?= htmlspecialchars($dia['saida']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
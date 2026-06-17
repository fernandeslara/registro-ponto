<?php include __DIR__ . '/../includes/header.php'; ?>

<h3 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h3>

<!-- Mensagem de erro (ex: sessão expirada), preenchida via JavaScript -->
<div id="mensagemErroDashboard" class="alert alert-danger d-none"></div>

<!-- Card de resumo -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-check-circle fs-2 text-success"></i>
                <h4 class="mt-2 mb-0" id="totalPresentes">--</h4>
                <small class="text-muted">Presentes hoje</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="bi bi-calendar-date fs-2 text-primary"></i>
                <h4 class="mt-2 mb-0" id="dataHoje">--</h4>
                <small class="text-muted">Data de hoje</small>
            </div>
        </div>
    </div>
</div>

<!-- Últimas batidas de ponto -->
<div class="card">
    <div class="card-header bg-white">
        <strong>Últimas batidas de ponto hoje</strong>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Funcionário</th>
                        <th>Entrada</th>
                        <th>Início Intervalo</th>
                        <th>Fim Intervalo</th>
                        <th>Saída</th>
                    </tr>
                </thead>
                <tbody id="corpoTabelaBatidas">
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Carregando registros...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
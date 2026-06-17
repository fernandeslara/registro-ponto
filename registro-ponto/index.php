<?php
include __DIR__ . '/../includes/header.php';
$nomeExibicao = $nomeUsuario !== '' ? $nomeUsuario : 'Funcionário';
?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">

        <!-- Saudação -->
        <h3 class="mb-1">Olá, <?= htmlspecialchars($nomeExibicao) ?> 👋</h3>
        <p class="text-muted mb-4">Use os botões abaixo para registrar seu ponto.</p>

        <!-- Relógio -->
        <div class="card text-center mb-4">
            <div class="card-body py-5">
                <div id="relogio" class="display-3 fw-bold">00:00:00</div>
                <div id="dataAtual" class="text-muted mt-1"></div>
            </div>
        </div>

        <!-- Mensagem de feedback (erro ou aviso), preenchida via JavaScript -->
        <div id="mensagemErroPonto" class="alert alert-danger d-none"></div>

        <!-- Botões de registro -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <button type="button" class="btn btn-success w-100 py-3" onclick="confirmarRegistro('entrada')">
                    <i class="bi bi-box-arrow-in-right"></i><br>Entrada
                </button>
            </div>
            <div class="col-6 col-md-3">
                <button type="button" class="btn btn-warning w-100 py-3" onclick="confirmarRegistro('inicio_intervalo')">
                    <i class="bi bi-cup-hot"></i><br>Início Intervalo
                </button>
            </div>
            <div class="col-6 col-md-3">
                <button type="button" class="btn btn-info w-100 py-3" onclick="confirmarRegistro('fim_intervalo')">
                    <i class="bi bi-arrow-counterclockwise"></i><br>Fim Intervalo
                </button>
            </div>
            <div class="col-6 col-md-3">
                <button type="button" class="btn btn-danger w-100 py-3" onclick="confirmarRegistro('saida')">
                    <i class="bi bi-box-arrow-right"></i><br>Saída
                </button>
            </div>
        </div>

        <!-- Resumo do dia (vindo da API dashboard.php) -->
        <div class="card">
            <div class="card-header bg-white">
                <strong>Meu ponto hoje</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Entrada</th>
                            <th>Início Intervalo</th>
                            <th>Fim Intervalo</th>
                            <th>Saída</th>
                        </tr>
                    </thead>
                    <tbody id="corpoTabelaPontoHoje">
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                Carregando...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
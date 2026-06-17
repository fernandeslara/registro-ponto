<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="bi bi-clock-history" style="font-size: 2.5rem; color: #1F3A5F;"></i>
                <h4 class="mt-2 mb-0">Acessar o Sistema</h4>
                <small class="text-muted">Informe seus dados para continuar</small>
            </div>

            <!-- Aqui vai aparecer a mensagem de erro vinda da API, via JavaScript -->
            <div id="mensagemErro" class="alert alert-danger py-2 d-none"></div>

            <form id="formLogin">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" id="btnEntrar">Entrar</button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= BASE_URL ?>/registro-ponto/sobre.php" class="text-decoration-none small">
                    Sobre o sistema
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
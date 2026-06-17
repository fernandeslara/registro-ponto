// ===========================================
// Login via fetch (API retorna JSON)
// ===========================================
const formLogin = document.getElementById('formLogin');

if (formLogin) {
    formLogin.addEventListener('submit', async function (evento) {
        evento.preventDefault(); // impede o recarregamento normal da página

        const email = document.getElementById('email').value.trim();
        const senha = document.getElementById('senha').value;
        const btnEntrar = document.getElementById('btnEntrar');
        const mensagemErro = document.getElementById('mensagemErro');

        // Esconde mensagem de erro anterior e desabilita o botão durante a requisição
        mensagemErro.classList.add('d-none');
        btnEntrar.disabled = true;
        btnEntrar.textContent = 'Entrando...';

        // Monta os dados no formato que a API espera (FormData -> $_POST no PHP)
        const dados = new FormData();
        dados.append('email', email);
        dados.append('senha', senha);

        try {
            const resposta = await fetch(`${window.API_URL}/auth/login.php`, {
                method: 'POST',
                body: dados,
                credentials: 'same-origin' // garante que o cookie de sessão (PHPSESSID) seja enviado/recebido
            });

            const resultado = await resposta.json();

            if (resposta.ok) {
                // Login deu certo: redireciona conforme o nível de acesso
                if (resultado.nivel_acesso === 'admin') {
                    window.location.href = `${window.BASE_URL}/admin/dashboard.php`;
                } else {
                    window.location.href = `${window.BASE_URL}/registro-ponto/index.php`;
                }
            } else {
                // API retornou erro (400, 401, 404, 500...) com uma mensagem em "erro"
                mensagemErro.textContent = resultado.erro || 'Erro ao fazer login.';
                mensagemErro.classList.remove('d-none');
            }
        } catch (erro) {
            mensagemErro.textContent = 'Não foi possível conectar ao servidor. Tente novamente.';
            mensagemErro.classList.remove('d-none');
        } finally {
            btnEntrar.disabled = false;
            btnEntrar.textContent = 'Entrar';
        }
    });
}
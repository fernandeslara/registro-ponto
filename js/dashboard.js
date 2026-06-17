// ===========================================
// Dashboard do ADMIN (admin/dashboard.php)
// ===========================================
const corpoTabelaBatidas = document.getElementById('corpoTabelaBatidas');

if (corpoTabelaBatidas) {
    carregarDashboardAdmin();
}

async function carregarDashboardAdmin() {
    const mensagemErro = document.getElementById('mensagemErroDashboard');

    try {
        const resposta = await fetch(`${window.API_URL}/sistema/dashboard.php`, {
            method: 'GET',
            credentials: 'same-origin'
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            // Ex: sessão expirada (401) ou outro erro retornado pela API
            mensagemErro.textContent = resultado.erro || 'Erro ao carregar o dashboard.';
            mensagemErro.classList.remove('d-none');

            // Se não estiver logado, manda para o login depois de mostrar a mensagem
            if (resposta.status === 401) {
                setTimeout(() => {
                    window.location.href = `${window.BASE_URL}/registro-ponto/login.php`;
                }, 2000);
            }
            return;
        }

        // Preenche os cards de resumo
        document.getElementById('totalPresentes').textContent = resultado.funcionarios_presentes ?? '--';
        document.getElementById('dataHoje').textContent = resultado.data ?? '--';

        // Preenche a tabela de últimas batidas
        if (!resultado.ultimas_batidas || resultado.ultimas_batidas.length === 0) {
            corpoTabelaBatidas.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Nenhuma batida de ponto registrada hoje.
                    </td>
                </tr>`;
            return;
        }

        corpoTabelaBatidas.innerHTML = resultado.ultimas_batidas.map(registro => `
            <tr>
                <td>${escaparHtml(registro.funcionario)}</td>
                <td>${registro.entrada ?? '-'}</td>
                <td>${registro.inicio_intervalo ?? '-'}</td>
                <td>${registro.fim_intervalo ?? '-'}</td>
                <td>${registro.saida ?? '-'}</td>
            </tr>
        `).join('');

    } catch (erro) {
        mensagemErro.textContent = 'Não foi possível conectar ao servidor.';
        mensagemErro.classList.remove('d-none');
    }
}
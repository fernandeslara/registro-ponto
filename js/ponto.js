// ===========================================
// Resumo do ponto de hoje (registro-ponto/index.php)
// Reaproveita a mesma API do dashboard, que retorna dados
// diferentes dependendo do nivel_acesso da sessão.
// ===========================================
const corpoTabelaPontoHoje = document.getElementById('corpoTabelaPontoHoje');

if (corpoTabelaPontoHoje) {
    carregarPontoHoje();
}

async function carregarPontoHoje() {
    const mensagemErro = document.getElementById('mensagemErroPonto');

    try {
        const resposta = await fetch(`${window.API_URL}/sistema/dashboard.php`, {
            method: 'GET',
            credentials: 'same-origin'
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            mensagemErro.textContent = resultado.erro || 'Erro ao carregar seu ponto de hoje.';
            mensagemErro.classList.remove('d-none');

            if (resposta.status === 401) {
                setTimeout(() => {
                    window.location.href = `${window.BASE_URL}/registro-ponto/login.php`;
                }, 2000);
            }
            return;
        }

        // Se ainda não houver nenhuma batida hoje, a API manda "mensagem" em vez dos horários
        if (resultado.mensagem) {
            corpoTabelaPontoHoje.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">
                        ${resultado.mensagem}
                    </td>
                </tr>`;
            return;
        }

        corpoTabelaPontoHoje.innerHTML = `
            <tr>
                <td>${resultado.entrada ?? '-'}</td>
                <td>${resultado.inicio_intervalo ?? '-'}</td>
                <td>${resultado.fim_intervalo ?? '-'}</td>
                <td>${resultado.saida ?? '-'}</td>
            </tr>`;

    } catch (erro) {
        mensagemErro.textContent = 'Não foi possível conectar ao servidor.';
        mensagemErro.classList.remove('d-none');
    }
}

// ===========================================
// Relógio em tempo real
// ===========================================
function atualizarRelogio() {
    const agora = new Date();

    const horas    = String(agora.getHours()).padStart(2, '0');
    const minutos  = String(agora.getMinutes()).padStart(2, '0');
    const segundos = String(agora.getSeconds()).padStart(2, '0');

    const relogioEl = document.getElementById('relogio');
    if (relogioEl) {
        relogioEl.textContent = `${horas}:${minutos}:${segundos}`;
    }

    const dataEl = document.getElementById('dataAtual');
    if (dataEl) {
        const opcoes = { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' };
        dataEl.textContent = agora.toLocaleDateString('pt-BR', opcoes);
    }
}

// Atualiza o relógio a cada segundo (se a página tiver o elemento #relogio)
if (document.getElementById('relogio')) {
    atualizarRelogio();
    setInterval(atualizarRelogio, 1000);
}

// ===========================================
// Botões de registro de ponto (registro-ponto/index.php)
// ===========================================
const NOMES_TIPO = {
    entrada: 'Entrada',
    inicio_intervalo: 'Início de Intervalo',
    fim_intervalo: 'Fim de Intervalo',
    saida: 'Saída'
};

async function confirmarRegistro(tipo) {
    const nomeTipo = NOMES_TIPO[tipo] || tipo;
    const confirmado = confirm(`Confirmar registro de ponto: ${nomeTipo}?`);
    if (!confirmado) return;

    const mensagemErro = document.getElementById('mensagemErroPonto');
    mensagemErro.classList.add('d-none');

    const dados = new FormData();
    dados.append('tipo_batida', tipo);

    try {
        const resposta = await fetch(`${window.API_URL}/sistema/registrar_ponto.php`, {
            method: 'POST',
            body: dados,
            credentials: 'same-origin'
        });

        const resultado = await resposta.json();

        if (resposta.ok) {
            // Mostra um aviso de sucesso e recarrega o resumo do dia
            alert(`✅ ${resultado.sucesso}\nHorário: ${resultado.horario}`);
            carregarPontoHoje();
        } else {
            mensagemErro.textContent = resultado.erro || 'Erro ao registrar ponto.';
            mensagemErro.classList.remove('d-none');

            if (resposta.status === 401) {
                setTimeout(() => {
                    window.location.href = `${window.BASE_URL}/registro-ponto/login.php`;
                }, 2000);
            }
        }
    } catch (erro) {
        mensagemErro.textContent = 'Não foi possível conectar ao servidor.';
        mensagemErro.classList.remove('d-none');
    }
}
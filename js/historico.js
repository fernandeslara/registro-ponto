// ===========================================
// Histórico do FUNCIONÁRIO (funcionario/historico.php)
// ===========================================
const formFiltroHistorico = document.getElementById('formFiltroHistorico');
const corpoTabelaHistorico = document.getElementById('corpoTabelaHistorico');

if (formFiltroHistorico && corpoTabelaHistorico) {
    // Carrega o mês atual ao entrar na página
    carregarHistoricoFuncionario();

    // Recarrega quando o formulário for submetido
    formFiltroHistorico.addEventListener('submit', function (e) {
        e.preventDefault();
        carregarHistoricoFuncionario();
    });
}

async function carregarHistoricoFuncionario() {
    const mensagemErro = document.getElementById('mensagemErroHistorico');
    mensagemErro.classList.add('d-none');
    corpoTabelaHistorico.innerHTML = `<tr><td colspan="5" class="text-center text-muted py-4">Carregando...</td></tr>`;

    const dados = new FormData();
    dados.append('mes', document.getElementById('mes').value);
    dados.append('ano', document.getElementById('ano').value);

    try {
        const resposta = await fetch(`${window.API_URL}/sistema/historico.php`, {
            method: 'POST',
            body: dados,
            credentials: 'same-origin'
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            mensagemErro.textContent = resultado.erro || 'Erro ao carregar histórico.';
            mensagemErro.classList.remove('d-none');
            corpoTabelaHistorico.innerHTML = '';
            return;
        }

        if (resultado.registros.length === 0) {
            corpoTabelaHistorico.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Nenhum registro encontrado para o período selecionado.
                    </td>
                </tr>`;
            return;
        }

        corpoTabelaHistorico.innerHTML = resultado.registros.map(r => `
            <tr>
                <td>${formatarData(r.data_registro)}</td>
                <td>${r.entrada ?? '-'}</td>
                <td>${r.inicio_intervalo ?? '-'}</td>
                <td>${r.fim_intervalo ?? '-'}</td>
                <td>${r.saida ?? '-'}</td>
            </tr>
        `).join('');

    } catch (erro) {
        mensagemErro.textContent = 'Não foi possível conectar ao servidor.';
        mensagemErro.classList.remove('d-none');
        corpoTabelaHistorico.innerHTML = '';
    }
}

// ===========================================
// Histórico ADMIN (admin/histprocp.php)
// ===========================================
const formFiltroHistAdmin = document.getElementById('formFiltroHistAdmin');
const corpoTabelaHistAdmin = document.getElementById('corpoTabelaHistAdmin');

if (formFiltroHistAdmin && corpoTabelaHistAdmin) {
    // Carrega lista de funcionários no select e o histórico do mês atual
    carregarFuncionariosSelect();
    carregarHistoricoAdmin();

    formFiltroHistAdmin.addEventListener('submit', function (e) {
        e.preventDefault();
        carregarHistoricoAdmin();
    });
}

async function carregarFuncionariosSelect() {
    try {
        const resposta = await fetch(`${window.API_URL}/sistema/funcionarios.php?acao=listar`, {
            method: 'GET',
            credentials: 'same-origin'
        });

        const resultado = await resposta.json();
        if (!resposta.ok || !resultado.funcionarios) return;

        const select = document.getElementById('funcionario_id');
        resultado.funcionarios.forEach(f => {
            const option = document.createElement('option');
            option.value = f.id;
            option.textContent = f.nome;
            select.appendChild(option);
        });
    } catch (erro) {
        console.error('Erro ao carregar funcionários no select:', erro);
    }
}

async function carregarHistoricoAdmin() {
    const mensagemErro = document.getElementById('mensagemErroHistAdmin');
    mensagemErro.classList.add('d-none');
    corpoTabelaHistAdmin.innerHTML = `<tr><td colspan="5" class="text-center text-muted py-4">Carregando...</td></tr>`;

    const dados = new FormData();
    dados.append('mes', document.getElementById('mes').value);
    dados.append('ano', document.getElementById('ano').value);

    const funcionarioId = document.getElementById('funcionario_id').value;
    if (funcionarioId) {
        dados.append('funcionario_id', funcionarioId);
    }

    try {
        const resposta = await fetch(`${window.API_URL}/sistema/historico.php`, {
            method: 'POST',
            body: dados,
            credentials: 'same-origin'
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            mensagemErro.textContent = resultado.erro || 'Erro ao carregar histórico.';
            mensagemErro.classList.remove('d-none');
            corpoTabelaHistAdmin.innerHTML = '';
            return;
        }

        if (resultado.registros.length === 0) {
            corpoTabelaHistAdmin.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Nenhum registro encontrado para os filtros selecionados.
                    </td>
                </tr>`;
            return;
        }

        corpoTabelaHistAdmin.innerHTML = resultado.registros.map(r => `
            <tr>
                <td>${formatarData(r.data_registro)}</td>
                <td>${r.entrada ?? '-'}</td>
                <td>${r.inicio_intervalo ?? '-'}</td>
                <td>${r.fim_intervalo ?? '-'}</td>
                <td>${r.saida ?? '-'}</td>
            </tr>
        `).join('');

    } catch (erro) {
        mensagemErro.textContent = 'Não foi possível conectar ao servidor.';
        mensagemErro.classList.remove('d-none');
        corpoTabelaHistAdmin.innerHTML = '';
    }
}

// ===========================================
// Utilitário: formata data de YYYY-MM-DD para DD/MM/YYYY
// ===========================================
function formatarData(dataISO) {
    if (!dataISO) return '-';
    const [ano, mes, dia] = dataISO.split('-');
    return `${dia}/${mes}/${ano}`;
}
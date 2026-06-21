// ===========================================
// Relatórios (admin/relatorios.php)
// ===========================================
const formFiltroRelatorio = document.getElementById('formFiltroRelatorio');
const corpoTabelaRelatorio = document.getElementById('corpoTabelaRelatorio');

if (formFiltroRelatorio && corpoTabelaRelatorio) {
    carregarRelatorio();

    formFiltroRelatorio.addEventListener('submit', function (e) {
        e.preventDefault();
        carregarRelatorio();
    });
}

async function carregarRelatorio() {
    const mensagemErro = document.getElementById('mensagemErroRelatorio');
    mensagemErro.classList.add('d-none');
    corpoTabelaRelatorio.innerHTML = `<tr><td colspan="3" class="text-center text-muted py-4">Carregando...</td></tr>`;

    const dados = new FormData();
    dados.append('mes', document.getElementById('mes').value);
    dados.append('ano', document.getElementById('ano').value);

    try {
        const resposta = await fetch(`${window.API_URL}/sistema/relatorios.php`, {
            method: 'POST',
            body: dados,
            credentials: 'same-origin'
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            mensagemErro.textContent = resultado.erro || 'Erro ao gerar relatório.';
            mensagemErro.classList.remove('d-none');
            corpoTabelaRelatorio.innerHTML = '';
            return;
        }

        document.getElementById('periodoRelatorio').textContent = resultado.periodo ?? '--';
        document.getElementById('totalFuncRelatorio').textContent = resultado.total_func ?? '--';

        if (!resultado.funcionarios || resultado.funcionarios.length === 0) {
            corpoTabelaRelatorio.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">
                        Nenhum dado disponível para o período selecionado.
                    </td>
                </tr>`;
            return;
        }

        corpoTabelaRelatorio.innerHTML = resultado.funcionarios.map((f, index) => `
            <tr>
                <td>${index + 1}</td>
                <td>${escaparHtml(f.nome)}</td>
                <td>${f.tempo_formatado}</td>
            </tr>
        `).join('');

    } catch (erro) {
        mensagemErro.textContent = 'Não foi possível conectar ao servidor.';
        mensagemErro.classList.remove('d-none');
        corpoTabelaRelatorio.innerHTML = '';
    }
}

// ===========================================
// Cadastrar / Editar funcionário (admin/editar.php)
// ===========================================
const formEditar = document.getElementById('formEditar');

if (formEditar) {
    const modoEdicao = document.getElementById('modoEdicao').value === '1';
    const cpfOriginal = document.getElementById('cpfOriginal').value;

    // Se for edição, busca os dados atuais do funcionário pra preencher o form
    if (modoEdicao && cpfOriginal) {
        preencherFormEditar(cpfOriginal);
    }

    formEditar.addEventListener('submit', async function (e) {
        e.preventDefault();

        const btnSalvar = document.getElementById('btnSalvar');
        const mensagem = document.getElementById('mensagemFeedbackEditar');
        mensagem.classList.add('d-none');
        btnSalvar.disabled = true;
        btnSalvar.textContent = 'Salvando...';

        const dados = new FormData();
        dados.append('acao', modoEdicao ? 'editar' : 'cadastrar');
        dados.append('nome', document.getElementById('nome').value);
        dados.append('cpf', modoEdicao ? cpfOriginal : document.getElementById('cpf').value);
        dados.append('email', document.getElementById('email').value);
        dados.append('cargo', document.getElementById('cargo').value);
        dados.append('departamento', document.getElementById('departamento').value);
        dados.append('horario_entrada', document.getElementById('horario_entrada').value);
        dados.append('horario_saida', document.getElementById('horario_saida').value);
        dados.append('nivel_acesso', document.getElementById('nivel_acesso').value);

        if (!modoEdicao) {
            dados.append('senha', document.getElementById('senha').value);
        }

        try {
            const resposta = await fetch(`${window.API_URL}/sistema/funcionarios.php`, {
                method: 'POST',
                body: dados,
                credentials: 'same-origin'
            });

            const resultado = await resposta.json();

            mensagem.classList.remove('d-none', 'alert-success', 'alert-danger');

            if (resposta.ok) {
                mensagem.classList.add('alert-success');
                mensagem.textContent = resultado.sucesso || 'Salvo com sucesso.';

                // Redireciona pra lista após 1.5 segundos
                setTimeout(() => {
                    window.location.href = `${window.BASE_URL}/admin/funcionarios.php`;
                }, 1500);
            } else {
                mensagem.classList.add('alert-danger');
                mensagem.textContent = resultado.erro || 'Erro ao salvar.';
            }
        } catch (erro) {
            mensagem.classList.remove('d-none');
            mensagem.classList.add('alert-danger');
            mensagem.textContent = 'Não foi possível conectar ao servidor.';
        } finally {
            btnSalvar.disabled = false;
            btnSalvar.textContent = 'Salvar';
        }
    });
}

async function preencherFormEditar(cpf) {
    try {
        const resposta = await fetch(`${window.API_URL}/sistema/funcionarios.php?acao=listar`, {
            method: 'GET',
            credentials: 'same-origin'
        });

        const resultado = await resposta.json();
        if (!resposta.ok || !resultado.funcionarios) return;

        const funcionario = resultado.funcionarios.find(f => f.cpf === cpf);
        if (!funcionario) return;

        document.getElementById('nome').value            = funcionario.nome ?? '';
        document.getElementById('cpf').value             = funcionario.cpf ?? '';
        document.getElementById('email').value           = funcionario.email ?? '';
        document.getElementById('cargo').value           = funcionario.cargo ?? '';
        document.getElementById('departamento').value    = funcionario.departamento ?? '';
        document.getElementById('horario_entrada').value = funcionario.horario_entrada ?? '';
        document.getElementById('horario_saida').value   = funcionario.horario_saida ?? '';
        document.getElementById('nivel_acesso').value    = funcionario.nivel_acesso ?? 'func';

    } catch (erro) {
        console.error('Erro ao buscar dados do funcionário:', erro);
    }
}
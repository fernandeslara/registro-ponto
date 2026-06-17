// ===========================================
// Listagem de funcionários (admin/funcionarios.php)
// ===========================================
const corpoTabela = document.getElementById('corpoTabelaFuncionarios');

if (corpoTabela) {
    carregarFuncionarios();
}

async function carregarFuncionarios() {
    try {
        const resposta = await fetch(`${window.API_URL}/sistema/funcionarios.php?acao=listar`, {
            method: 'GET',
            credentials: 'same-origin'
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            corpoTabela.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-danger py-4">
                        ${resultado.erro || 'Erro ao carregar funcionários.'}
                    </td>
                </tr>`;
            return;
        }

        if (resultado.funcionarios.length === 0) {
            corpoTabela.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Nenhum funcionário cadastrado.
                    </td>
                </tr>`;
            return;
        }

        // Monta uma linha de tabela para cada funcionário retornado pela API
        corpoTabela.innerHTML = resultado.funcionarios.map(funcionario => `
            <tr>
                <td>${funcionario.id}</td>
                <td>${escaparHtml(funcionario.nome)}</td>
                <td>${escaparHtml(funcionario.email ?? '')}</td>
                <td>${escaparHtml(funcionario.cargo ?? '')}</td>
                <td>${escaparHtml(funcionario.departamento ?? '')}</td>
                <td class="text-end">
                    <a href="${window.BASE_URL}/admin/editar.php?cpf=${encodeURIComponent(funcionario.cpf)}"
                       class="btn btn-sm btn-outline-primary" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger" title="Excluir"
                            onclick="excluirFuncionario('${funcionario.cpf}', '${escaparHtml(funcionario.nome)}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');

    } catch (erro) {
        corpoTabela.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-danger py-4">
                    Não foi possível conectar ao servidor.
                </td>
            </tr>`;
    }
}

async function excluirFuncionario(cpf, nome) {
    const confirmado = confirm(`Tem certeza que deseja excluir o funcionário "${nome}"?`);
    if (!confirmado) return;

    const mensagemFeedback = document.getElementById('mensagemFeedback');

    const dados = new FormData();
    dados.append('acao', 'excluir');
    dados.append('cpf', cpf);

    try {
        const resposta = await fetch(`${window.API_URL}/sistema/funcionarios.php`, {
            method: 'POST',
            body: dados,
            credentials: 'same-origin'
        });

        const resultado = await resposta.json();

        mensagemFeedback.classList.remove('d-none', 'alert-success', 'alert-danger');

        if (resposta.ok) {
            mensagemFeedback.classList.add('alert-success');
            mensagemFeedback.textContent = resultado.sucesso || 'Funcionário excluído com sucesso.';
            carregarFuncionarios(); // recarrega a lista sem precisar atualizar a página
        } else {
            mensagemFeedback.classList.add('alert-danger');
            mensagemFeedback.textContent = resultado.erro || 'Erro ao excluir funcionário.';
        }
    } catch (erro) {
        mensagemFeedback.classList.remove('d-none');
        mensagemFeedback.classList.add('alert-danger');
        mensagemFeedback.textContent = 'Não foi possível conectar ao servidor.';
    }
}

// Função simples para evitar problemas de HTML ao inserir texto vindo da API
function escaparHtml(texto) {
    const div = document.createElement('div');
    div.textContent = texto;
    return div.innerHTML;
}
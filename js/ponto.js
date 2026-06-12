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
// Confirmação ao registrar o ponto
// ===========================================
const NOMES_TIPO = {
    entrada: 'Entrada',
    inicio_intervalo: 'Início de Intervalo',
    fim_intervalo: 'Fim de Intervalo',
    saida: 'Saída'
};

function confirmarRegistro(tipo) {
    const nomeTipo = NOMES_TIPO[tipo] || tipo;
    const confirmado = confirm(`Confirmar registro de ponto: ${nomeTipo}?`);

    if (confirmado) {
        // TODO: quando o backend estiver pronto, enviar esse registro
        // via fetch/POST para um arquivo PHP que grava no banco de dados.
        // Por enquanto, apenas mostramos um aviso de confirmação.
        alert(`Ponto registrado: ${nomeTipo}`);
    }
}
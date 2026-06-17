<?php

session_start();
require_once '../config/conexao.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['nivel_acesso']) || $_SESSION['nivel_acesso'] !== 'admin'){
    http_response_code(403);
    echo json_encode(['erro' => 'Acesso negado. Apenas administradores podem ver relatórios.']);
    exit;
}

$mes = $_POST['mes'] ?? date('m');
$ano = $_POST['ano'] ?? date('Y');
$mes = (int) $mes;
$ano = (int) $ano;

if($mes < 1 || $mes > 12){
    http_response_code(400);
    echo json_encode(['erro' => 'Mês inválido. Informe um valor entre 1 e 12.']);
    exit;
}

if($ano < 2000 || $ano > (int) date('Y')){
    http_response_code(400);
    echo json_encode(['erro' => 'Ano inválido. Informe um ano entre 2000 e ' . date('Y') . '.']);
    exit;
}

try{
    $sql = "SELECT 
                u.id,
                u.nome,
                SUM(
                    TIME_TO_SEC(TIMEDIFF(r.inicio_intervalo, r.entrada)) + 
                    TIME_TO_SEC(TIMEDIFF(r.saida, r.fim_intervalo))
                ) AS total_segundos
            FROM usuarios u
            LEFT JOIN registros r ON u.id = r.usuario_id 
                AND MONTH(r.data_registro) = $mes
                AND YEAR(r.data_registro)  = $ano
            WHERE u.nivel_acesso = 'func'
            GROUP BY u.id, u.nome";

    $resultado = $conn->query($sql);
    $funcionarios = [];

    while($row = $resultado->fetch_assoc()){
        $segundos_totais = (int) ($row['total_segundos'] ?? 0);
        $horas = floor($segundos_totais / 3600);
        $minutos = floor(($segundos_totais % 3600) / 60);

        $funcionarios[] = [
            'id' => (int) $row['id'],
            'nome' => $row['nome'],
            'total_segundos' => $segundos_totais,
            'horas' => (int) $horas,
            'minutos' => (int) $minutos,
            'tempo_formatado'=> "{$horas}h " . str_pad($minutos, 2, '0', STR_PAD_LEFT) . "min",
        ];
    }

    echo json_encode([
        'periodo' => str_pad($mes, 2, '0', STR_PAD_LEFT) . '/' . $ano,
        'total_func' => count($funcionarios),
        'funcionarios' => $funcionarios,
    ]);

}catch(Exception $e){
    echo json_encode(['erro' => 'Erro na geração do relatório: ' . $e->getMessage()]);
}

$conn->close();
?>
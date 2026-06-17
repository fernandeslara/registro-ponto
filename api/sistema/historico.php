<?php
session_start();
require_once "../config/conexao.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['usuario_id'])){
    http_response_code(401);
    echo json_encode(['erro' => 'Acesso negado. Faça login para continuar.']);
    exit;
}

$usuario_id_logado = $_SESSION['usuario_id'];
$nivel_acesso = $_SESSION['nivel_acesso'] ?? 'func';

$mes_filtro = (int) ($_POST['mes'] ?? date('m'));
$ano_filtro = (int) ($_POST['ano'] ?? date('Y'));

if($mes_filtro < 1 || $mes_filtro > 12){
    http_response_code(400);
    echo json_encode(['erro' => 'Mês inválido. Informe um valor entre 1 e 12.']);
    exit;
}

if($ano_filtro < 2000 || $ano_filtro > (int) date('Y')){
    http_response_code(400);
    echo json_encode(['erro' => 'Ano inválido. Informe um ano entre 2000 e ' . date('Y') . '.']);
    exit;
}

if($nivel_acesso === 'admin' && !empty($_POST['funcionario_id'])){
    $id_busca = (int) $_POST['funcionario_id'];
}else{
    $id_busca = (int) $usuario_id_logado;
}

try{
    $sql = "SELECT id, data_registro, entrada, inicio_intervalo, fim_intervalo, saida 
            FROM registros 
            WHERE usuario_id = $id_busca
              AND MONTH(data_registro) = $mes_filtro
              AND YEAR(data_registro)  = $ano_filtro
            ORDER BY data_registro DESC";

    $resultado = $conn->query($sql);

    $registros = [];
    while($ponto = $resultado->fetch_assoc()){
        $registros[] = [
            'id' => (int) $ponto['id'],
            'data_registro' => $ponto['data_registro'],
            'entrada' => $ponto['entrada'] ?? null,
            'inicio_intervalo' => $ponto['inicio_intervalo'] ?? null,
            'fim_intervalo' => $ponto['fim_intervalo'] ?? null,
            'saida' => $ponto['saida'] ?? null,
        ];
    }

    echo json_encode([
        'funcionario_id' => $id_busca,
        'periodo' => str_pad($mes_filtro, 2, '0', STR_PAD_LEFT) . '/' . $ano_filtro,
        'total_registros' => count($registros),
        'registros' => $registros,
    ]);

}catch(Exception $e){
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao buscar histórico: ' . $e->getMessage()]);
}

$conn->close();
?>
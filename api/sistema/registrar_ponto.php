<?php

session_start();
require_once '../config/conexao.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['usuario_id'])){
    http_response_code(401);
    echo json_encode(['erro' => 'Você precisa fazer login para registrar o ponto.']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$tipo_batida = $_POST['tipo_batida'] ?? '';
$data_hoje = date('Y-m-d');
$hora_agora = date('H:i:s');

$batidas_validas = ['entrada', 'inicio_intervalo', 'fim_intervalo', 'saida'];

if(empty($tipo_batida)){
    http_response_code(400);
    echo json_encode(['erro' => 'Tipo de batida não informado.']);
    exit;
}

if(!in_array($tipo_batida, $batidas_validas)){
    http_response_code(400);
    echo json_encode(['erro' => 'Tipo de batida inválido.', 'validos' => $batidas_validas]);
    exit;
}

try{
    if($tipo_batida === 'entrada'){
        $sql = "INSERT INTO registros (usuario_id, data_registro, entrada) 
                VALUES ($usuario_id, '$data_hoje', '$hora_agora')";
        $conn->query($sql);
        echo json_encode(['sucesso' => 'Entrada registrada.', 'horario' => $hora_agora]);

    }else{
        $sql = "UPDATE registros 
                SET $tipo_batida = '$hora_agora' 
                WHERE usuario_id = $usuario_id AND data_registro = '$data_hoje'";
        $conn->query($sql);
        echo json_encode(['sucesso' => 'Batida registrada.', 'tipo' => $tipo_batida, 'horario' => $hora_agora]);
    }

}catch(Exception $e){
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao registrar ponto: ' . $e->getMessage()]);
}

$conn->close();
?>
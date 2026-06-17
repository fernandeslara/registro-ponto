<?php

session_start();
require_once "../config/conexao.php";
header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['usuario_id'])){
    http_response_code(401);
    echo json_encode(['erro' => 'Você precisa estar logado para acessar o Dashboard.']);
    exit;
}

$usuario_id_logado = $_SESSION['usuario_id'];
$nivel_acesso = $_SESSION['nivel_acesso'] ?? 'func';
$data_hoje = date('Y-m-d');

if($nivel_acesso === 'admin'){
    // DASHBOARD ADMIIN
    $sql_presentes = "SELECT COUNT(DISTINCT usuario_id) as total 
                        FROM registros 
                        WHERE data_registro = '$data_hoje' 
                        AND entrada IS NOT NULL";

    $res_presentes = $conn->query($sql_presentes);
    $total_presentes = (int) $res_presentes->fetch_assoc()['total'];

    $sql_ultimas = "SELECT r.*, u.nome FROM registros r 
                    JOIN usuarios u ON r.usuario_id = u.id 
                    WHERE r.data_registro = '$data_hoje' 
                    ORDER BY r.id DESC LIMIT 10";
    $res_ultimas = $conn->query($sql_ultimas);

    $ultimas_batidas = [];
    while($row = $res_ultimas->fetch_assoc()){
        $ultimas_batidas[] = [
            'funcionario' => $row['nome'],
            'entrada' => $row['entrada'],
            'inicio_intervalo' => $row['inicio_intervalo'],
            'fim_intervalo' => $row['fim_intervalo'],
            'saida' => $row['saida'],
        ];
    }

    echo json_encode([
        'perfil' => 'admin',
        'data' => date('d/m/Y'),
        'funcionarios_presentes' => $total_presentes,
        'ultimas_batidas' => $ultimas_batidas,
    ]);

} else {
    // DASHBOARD FUNCIONÁRIO 

    $sql_ponto_hoje = "SELECT * FROM registros 
                        WHERE usuario_id = $usuario_id_logado 
                        AND data_registro = '$data_hoje'";
    $res_ponto_hoje = $conn->query($sql_ponto_hoje);

    if($res_ponto_hoje->num_rows > 0){
        $ponto = $res_ponto_hoje->fetch_assoc();
        echo json_encode([
            'perfil' => 'funcionario',
            'data' => date('d/m/Y'),
            'entrada' => $ponto['entrada'],
            'inicio_intervalo' => $ponto['inicio_intervalo'],
            'fim_intervalo' => $ponto['fim_intervalo'],
            'saida' => $ponto['saida'],
        ]);
    }else{
        echo json_encode([
            'perfil' => 'funcionario',
            'data' => date('d/m/Y'),
            'mensagem' => 'Nenhuma batida de ponto registrada hoje.',
        ]);
    }
}

$conn->close();
?>
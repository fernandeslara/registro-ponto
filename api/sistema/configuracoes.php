<?php

session_start();
require_once "../config/conexao.php";
header('Content-Type: application/json; charset=utf-8');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!isset($_SESSION['nivel_acesso']) || $_SESSION['nivel_acesso'] !== 'admin'){
    http_response_code(403);
    echo json_encode(['erro' => 'Acesso restrito apenas para administradores.']);
    exit;
}

$acao = $_REQUEST['acao'] ?? 'listar';

switch($acao){

    case 'atualizar':
        $nome_empresa = trim($_POST['nome_empresa'] ?? '');
        $tolerancia_atraso = (int) ($_POST['tolerancia_atraso'] ?? 10);
        $intervalo_padrao  = (int) ($_POST['intervalo_padrao'] ?? 60);

        if(empty($nome_empresa)){
            http_response_code(400);
            echo json_encode(['erro' => 'O nome da empresa não pode estar vazio.']);
            break;
        }

        if($tolerancia_atraso < 0 || $intervalo_padrao < 0){
            http_response_code(400);
            echo json_encode(['erro' => 'Tolerância e intervalo devem ser valores positivos.']);
            break;
        }

        $sql = "UPDATE configuracoes 
                SET nome_empresa = '$nome_empresa', 
                    tolerancia_atraso = $tolerancia_atraso, 
                    intervalo_padrao = $intervalo_padrao 
                WHERE id = 1";

        try{
            $conn->query($sql);
            echo json_encode(['sucesso' => 'Configurações atualizadas com sucesso.']);
        }catch (Exception $e){
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao atualizar configurações: ' . $e->getMessage()]);
        }
        break;

    case 'listar':
    default:
        $sql = "SELECT nome_empresa, tolerancia_atraso, intervalo_padrao 
                FROM configuracoes
                WHERE id = 1";

        try{
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0){
                $config = $result->fetch_assoc();
                echo json_encode([
                    'nome_empresa'      => $config['nome_empresa'],
                    'tolerancia_atraso' => (int) $config['tolerancia_atraso'],
                    'intervalo_padrao'  => (int) $config['intervalo_padrao'],
                ]);
            }else{
                echo json_encode(['erro' => 'Nenhuma configuração encontrada no banco de dados.']);
            }
        }catch(Exception $e){
            echo json_encode(['erro' => 'Erro ao buscar configurações: ' . $e->getMessage()]);
        }
        break;
}

$conn->close();
?>
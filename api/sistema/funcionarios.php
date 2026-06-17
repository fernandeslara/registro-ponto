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

$nivel_acesso_sessao = $_SESSION['nivel_acesso'] ?? 'func';
$acoes_admin = ['cadastrar', 'editar', 'excluir'];
$acao = $_POST['acao'] ?? $_GET['acao'] ?? 'listar';

if(in_array($acao, $acoes_admin) && $nivel_acesso_sessao !== 'admin'){
    http_response_code(403);
    echo json_encode(['erro' => 'Acesso negado. Apenas administradores podem realizar esta acao.']);
    exit;
}

$niveis_validos = ['admin', 'func'];

switch($acao){

    case 'cadastrar':
        $nome = trim($_POST['nome'] ?? '');
        $cpf = trim($_POST['cpf'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = trim($_POST['senha'] ?? '');
        $acesso = trim($_POST['nivel_acesso'] ?? 'func');
        $cargo = trim($_POST['cargo'] ?? '');
        $departamento = trim($_POST['departamento'] ?? '');
        $entrada = trim($_POST['horario_entrada'] ?? '');
        $saida = trim($_POST['horario_saida'] ?? '');

        if(empty($nome) || empty($cpf) || empty($senha) || empty($entrada) || empty($saida)){
            http_response_code(400);
            echo json_encode(['erro' => 'Campos obrigatórios ausentes: nome, cpf, senha, horario_entrada e horario_saida.']);
            exit;
        }

        if(!in_array($acesso, $niveis_validos)){
            http_response_code(400);
            echo json_encode(['erro' => 'Nível de acesso inválido. Use "admin" ou "func".']);
            exit;
        }

        try{
            $sql = "INSERT INTO usuarios (nome, cpf, email, senha, nivel_acesso, cargo, departamento, horario_entrada, horario_saida) 
                    VALUES ('$nome', '$cpf', '$email', '$senha', '$acesso', '$cargo', '$departamento', '$entrada', '$saida')";

            $conn->query($sql);
            http_response_code(201);
            echo json_encode(['sucesso' => 'Funcionário cadastrado com sucesso.']);
        }catch (Exception $e){
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao cadastrar funcionário: ' . $e->getMessage()]);
        }

        break;

    case 'editar':
        $cpf = trim($_POST['cpf'] ?? '');

        if(empty($cpf)){
            http_response_code(400);
            echo json_encode(['erro' => 'CPF não informado.']);
            exit;
        }

        try{
            $sql_busca = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
            $resultado = $conn->query($sql_busca);
            $usuario_atual = $resultado->fetch_assoc();

            if(!$usuario_atual){
                http_response_code(404);
                echo json_encode(['erro' => 'Funcionário não encontrado.']);
                exit;
            }

            $nome = !empty($_POST['nome']) ? trim($_POST['nome']) : $usuario_atual['nome'];
            $email = !empty($_POST['email']) ? trim($_POST['email']) : $usuario_atual['email'];
            $acesso = !empty($_POST['nivel_acesso']) ? trim($_POST['nivel_acesso']) : $usuario_atual['nivel_acesso'];
            $cargo = !empty($_POST['cargo']) ? trim($_POST['cargo']) : $usuario_atual['cargo'];
            $departamento = !empty($_POST['departamento']) ? trim($_POST['departamento']) : $usuario_atual['departamento'];
            $entrada = !empty($_POST['horario_entrada']) ? trim($_POST['horario_entrada']) : $usuario_atual['horario_entrada'];
            $saida = !empty($_POST['horario_saida']) ? trim($_POST['horario_saida']) : $usuario_atual['horario_saida'];

            if(!in_array($acesso, $niveis_validos)){
                http_response_code(400);
                echo json_encode(['erro' => 'Nível de acesso inválido. Use "admin" ou "func".']);
                exit;
            }

            $sql = "UPDATE usuarios 
                    SET nome = '$nome', 
                        email = '$email', 
                        nivel_acesso = '$acesso',
                        cargo = '$cargo',
                        departamento = '$departamento',
                        horario_entrada = '$entrada',
                        horario_saida = '$saida'
                    WHERE cpf = '$cpf'";

            $conn->query($sql);
            echo json_encode(['sucesso' => 'Funcionário atualizado com sucesso.']);
        }catch(Exception $e){
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao atualizar funcionário: ' . $e->getMessage()]);
        }
        break;

    case 'excluir':
        $cpf = trim($_POST['cpf'] ?? '');

        if(empty($cpf)){
            http_response_code(400);
            echo json_encode(['erro' => 'CPF não informado.']);
            exit;
        }

        try{
            $sql_busca = "SELECT id FROM usuarios WHERE cpf = '$cpf'";
            $resultado = $conn->query($sql_busca);

            if($resultado->num_rows === 0){
                http_response_code(404);
                echo json_encode(['erro' => 'Funcionário não encontrado.']);
                exit;
            }

            $sql = "DELETE FROM usuarios WHERE cpf = '$cpf'";
            $conn->query($sql);
            echo json_encode(['sucesso' => 'Funcionário excluído com sucesso.']);
        }catch(Exception $e){
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao excluir funcionário: ' . $e->getMessage()]);
        }
        break;

    case 'listar':
    default:
        try{
            if($nivel_acesso_sessao === 'admin'){
            $sql = "SELECT id, nome, email, cargo, departamento, cpf 
                    FROM usuarios";
            }else{
                $sql = "SELECT id, nome, email, cargo, departamento, cpf 
                        FROM usuarios 
                        WHERE id = {$_SESSION['usuario_id']}";
            }

            $result = $conn->query($sql);

            $funcionarios = [];
            while($row = $result->fetch_assoc()){
                $funcionarios[] = [
                    'id' => (int) $row['id'],
                    'nome' => $row['nome'],
                    'email' => $row['email'],
                    'cargo' => $row['cargo'],
                    'departamento'=> $row['departamento'],
                    'cpf' => $row['cpf'],
                ];
            }

            echo json_encode([
                'total' => count($funcionarios),
                'funcionarios' => $funcionarios,
            ]);
        }catch(Exception $e){
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao listar funcionários: ' . $e->getMessage()]);
        }
        break;
}

$conn->close();
?>
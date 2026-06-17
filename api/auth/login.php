<?php

session_start();
require_once '../config/conexao.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json; charset=utf-8');

$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if(empty($email) || empty($senha)){
    http_response_code(400);
    echo json_encode(['erro' => 'Por favor, preencha o e-mail e a senha.']);
    exit;
}

try{
    $sql = "SELECT id, nome, senha, nivel_acesso 
            FROM usuarios
            WHERE email = '$email'";
    $resultado = $conn->query($sql);

    if($resultado->num_rows == 1){
        $usuario = $resultado->fetch_assoc();

        if($senha == $usuario['senha']){
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['nivel_acesso'] = $usuario['nivel_acesso'];

            echo json_encode([
                'sucesso' => 'Login efetuado com sucesso.',
                'nome' => $usuario['nome'],
                'nivel_acesso' => $usuario['nivel_acesso'],
            ]);
        }else{
            http_response_code(401);
            echo json_encode(['erro' => 'Senha incorreta.']);
        }
    }else{
        http_response_code(404);
        echo json_encode(['erro' => 'Usuário não encontrado.']);
    }

}catch(Exception $e){
    http_response_code(500);
    echo json_encode(['erro' => 'Erro no banco: ' . $e->getMessage()]);
}

$conn->close();
?>
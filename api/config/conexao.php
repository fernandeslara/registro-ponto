<?php
date_default_timezone_set('America/Sao_Paulo');

$host = "localhost";
$user = "root"; // usuário criado
$pass = "";         // senha que você definiu
$db = "pontofacil_db";   // nome do banco

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    die("Erro: " . $conn->connect_error);
}

?>
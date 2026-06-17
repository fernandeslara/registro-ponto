<?php
date_default_timezone_set('America/Sao_Paulo');

$host = "localhost";
$user = "root";
$pass = "";
$db = "pontofacil_db";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    die("Erro: " . $conn->connect_error);
}

?>
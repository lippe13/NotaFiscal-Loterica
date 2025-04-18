<?php

$host = '127.0.0.1'; // Endereço do servidor de banco de dados
$dbname = 'a2023951571@teiacoltec.org'; // Nome do banco de dados
$user = 'a2023951571@teiacoltec.org'; // Usuário do banco de dados
$pass = '@Coltec2024'; // Senha do banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    
    echo "Erro na conexão: " . $e->getMessage();
    exit();
}
?>

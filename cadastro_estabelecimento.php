<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $local = $_POST['local'];
    $cnpj = $_POST['cnpj'];

    try {
        
        $stmt = $pdo->prepare("SELECT * FROM Estabelecimento WHERE CNPJ = :cnpj");
        $stmt->execute(['cnpj' => $cnpj]);
        $estabelecimento = $stmt->fetch();

        if ($estabelecimento) {
            echo "<p>Este CNPJ já está cadastrado! <a href='cadastro_estabelecimento.php'>Tente novamente</a></p>";
        } else {
            
            $stmt = $pdo->prepare("INSERT INTO Estabelecimento (Nome, Local, CNPJ) 
                                   VALUES (:nome, :local, :cnpj)");
            $stmt->execute([
                'nome' => $nome,
                'local' => $local,
                'cnpj' => $cnpj
            ]);

            echo "<p>Estabelecimento cadastrado com sucesso!</p>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Estabelecimento</title>
    <link rel="stylesheet" href="cadastro_estabelecimento.css">
</head>
<body>
    <div class="login-container">
        <h2>Cadastro de Estabelecimento</h2>
        <form method="POST" action="cadastro_estabelecimento.php">
            <div class="input-group">
                <label for="nome">Nome do Estabelecimento:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="input-group">
                <label for="local">Local:</label>
                <input type="text" id="local" name="local" required>
            </div>
            <div class="input-group">
                <label for="cnpj">CNPJ:</label>
                <input type="text" id="cnpj" name="cnpj" required>
            </div>
            <button type="submit" class="btn">Cadastrar</button>
        </form>
        <a href="index.php" class="btn voltar">Voltar à Tela Inicial</a>
    </div>
</body>
</html>

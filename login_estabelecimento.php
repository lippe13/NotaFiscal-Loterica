<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cnpj = $_POST['cnpj'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM Estabelecimento WHERE Nome = :nome AND CNPJ = :cnpj");
        $stmt->execute(['nome' => $nome, 'cnpj' => $cnpj]);
        $estabelecimento = $stmt->fetch();

        if ($estabelecimento) {
            $_SESSION['estabelecimento_id'] = $estabelecimento['idEstabelecimento'];
            header('Location: dashboard_estabelecimento.php');
            exit;
        } else {
            echo "<p>Nome ou CNPJ inválido. Tente novamente.</p>";
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
    <title>Login Estabelecimento</title>
    <link rel="stylesheet" href="login_estabelecimento.css">
</head>
<body>
    <div class="login-container">
        <h2>Login Estabelecimento</h2>
        <form method="POST" action="login_estabelecimento.php">
            <div class="input-group">
                <label for="nome">Nome do Estabelecimento:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="input-group">
                <label for="cnpj">CNPJ:</label>
                <input type="text" id="cnpj" name="cnpj" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <a href="index.php" class="voltar">Voltar à Tela Inicial</a>
    </div>
</body>
</html>

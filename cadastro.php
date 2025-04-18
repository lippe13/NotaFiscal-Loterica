<?php
session_start();
include 'conexao.php';

$mensagem = '';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $senha = $_POST['senha'];

    try {
        
        $stmt = $pdo->prepare("SELECT * FROM User WHERE CPF = :cpf");
        $stmt->execute(['cpf' => $cpf]);
        $user = $stmt->fetch();

        if ($user) {
            $mensagem = "Este CPF já está cadastrado! <a href='cadastro.php'>Tente novamente</a>";
        } else {
            
            $stmt = $pdo->prepare("INSERT INTO User (CPF, Nome, Email, Celular, Senha, Pontos) 
                                   VALUES (:cpf, :nome, :email, :celular, :senha, 0)");
            $stmt->execute([
                'cpf' => $cpf,
                'nome' => $nome,
                'email' => $email,
                'celular' => $celular,
                'senha' => $senha
            ]);

            $mensagem = "User cadastrado com sucesso!";
        }
    } catch (PDOException $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <div class="login-container">
        <h2>Cadastro de Usuário</h2>
        <form method="POST" action="cadastro.php">
            <div class="input-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required>
            </div>
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="celular">Celular:</label>
                <input type="text" id="celular" name="celular" required>
            </div>
            <div class="input-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn">Cadastrar</button>
        </form>

        <?php if ($mensagem): ?>
            <p class="mensagem"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <a href="index.php" class="btn voltar">Voltar à Tela Inicial</a>
    </div>
</body>
</html>

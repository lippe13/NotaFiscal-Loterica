<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lotérica</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>

    <main>
        <form action="process_login.php" method="POST" class="login-form">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

            <label for="tipo">Logar como:</label>
            <select id="tipo" name="tipo" required>
                <option value="user">Usuário</option>
                <option value="adm">Administrador</option>
            </select>

            <button type="submit" class="btn">Entrar</button>
        </form>
    </main>

    <a href="index.php" class="btn voltar">Voltar à Tela Inicial</a>
    
</body>
</html>

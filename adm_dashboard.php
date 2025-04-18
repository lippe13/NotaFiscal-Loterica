<?php
session_start();

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'adm') {
    header("Location: login.php");
    exit;
}

include 'conexao.php'; 

$estabelecimentos_query = "SELECT * FROM Estabelecimento";
$estabelecimentos_result = $pdo->query($estabelecimentos_query);

$usuarios_query = "SELECT * FROM User";
$usuarios_result = $pdo->query($usuarios_query);

$compras_query = "SELECT c.Valor, c.Data, u.Nome AS UserName, e.Nome AS EstabelecimentoName
                  FROM Compra c
                  JOIN User u ON c.Compra_User = u.idUser
                  JOIN Estabelecimento e ON c.Compra_Estabelecimento = e.idEstabelecimento";
$compras_result = $pdo->query($compras_query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="adm_dashboard.css">
</head>
<body>
    <header>
        <h1>Painel de Administração</h1>
    </header>

    <main>
        <section>
            <h2>Estabelecimentos Cadastrados</h2>
            <?php if ($estabelecimentos_result->rowCount() > 0): ?>
                <ul>
                    <?php while ($estabelecimento = $estabelecimentos_result->fetch()): ?>
                        <li>Nome: <?php echo htmlspecialchars($estabelecimento['Nome']); ?> | CNPJ: <?php echo htmlspecialchars($estabelecimento['CNPJ']); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Ainda não há estabelecimentos cadastrados.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Usuários Cadastrados</h2>
            <?php if ($usuarios_result->rowCount() > 0): ?>
                <ul>
                    <?php while ($usuario = $usuarios_result->fetch()): ?>
                        <li>Nome: <?php echo htmlspecialchars($usuario['Nome']); ?> | CPF: <?php echo htmlspecialchars($usuario['CPF']); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Ainda não há usuários cadastrados.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Compras/Vendas Realizadas</h2>
            <p class="info-text">Estabelecimentos e Users não encontrados aqui, não realizaram compras/vendas</p>
            <?php if ($compras_result->rowCount() > 0): ?>
                <ul>
                    <?php while ($compra = $compras_result->fetch()): ?>
                        <li>Nome do Usuário: <?php echo htmlspecialchars($compra['UserName']); ?> | Nome do Estabelecimento: <?php echo htmlspecialchars($compra['EstabelecimentoName']); ?> | Data: <?php echo htmlspecialchars($compra['Data']); ?> | Valor: R$ <?php echo number_format($compra['Valor'], 2, ',', '.'); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Ainda não foram realizadas compras/vendas.</p>
            <?php endif; ?>
        </section>

        <section>
            <a href="index.php" class="voltar">Voltar ao Início</a>
        </section>
    </main>
</body>
</html>

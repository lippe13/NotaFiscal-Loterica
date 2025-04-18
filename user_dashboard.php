<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'user') {
    header('Location: login.php');
    exit();
}

$idUser = $_SESSION['user_id']; 
$nomeUser = $_SESSION['user_name'];

try {

    $stmtCompras = $pdo->prepare("
        SELECT c.Valor, c.Data, e.Nome AS Estabelecimento 
        FROM Compra c
        JOIN Estabelecimento e ON c.Compra_Estabelecimento = e.idEstabelecimento
        WHERE c.Compra_User = :idUser
    ");
    $stmtCompras->execute(['idUser' => $idUser]);
    $compras = $stmtCompras->fetchAll();

    $stmtPontos = $pdo->prepare("
        SELECT SUM(Valor) AS TotalGasto 
        FROM Compra 
        WHERE Compra_User = :idUser
    ");
    $stmtPontos->execute(['idUser' => $idUser]);
    $totalGasto = $stmtPontos->fetchColumn();
    $pontos = $totalGasto ? $totalGasto : 0;

    $stmtUpdatePontos = $pdo->prepare("
        UPDATE User 
        SET Pontos = :pontos 
        WHERE idUser = :idUser
    ");
    $stmtUpdatePontos->execute([
        'pontos' => $pontos,
        'idUser' => $idUser
    ]);

    $stmtEstabelecimentos = $pdo->query("SELECT * FROM Estabelecimento");
    $estabelecimentos = $stmtEstabelecimentos->fetchAll();
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header>
        <h1>Bem-vindo(a), <?php echo htmlspecialchars($nomeUser); ?>!</h1>
    </header>

    <main>
        <section>
            <h2>Compras Feitas</h2>
            <?php if ($compras): ?>
                <ul>
                    <?php foreach ($compras as $compra): ?>
                        <li>
                            Valor: R$ <?php echo number_format($compra['Valor'], 2, ',', '.'); ?> |
                            Data: <?php echo date('d/m/Y', strtotime($compra['Data'])); ?> |
                            Estabelecimento: <?php echo htmlspecialchars($compra['Estabelecimento']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Você ainda não realizou nenhuma compra.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Fazer uma Compra</h2>
            <form action="process_compra.php" method="POST">
                <label for="valor">Valor (R$):</label>
                <input type="number" step="0.01" id="valor" name="valor" required>

                <label for="data">Data:</label>
                <input type="date" id="data" name="data" required>

                <label for="estabelecimento">Estabelecimento:</label>
                <select id="estabelecimento" name="estabelecimento" required>
                    <?php foreach ($estabelecimentos as $estabelecimento): ?>
                        <option value="<?php echo $estabelecimento['idEstabelecimento']; ?>">
                            <?php echo htmlspecialchars($estabelecimento['Nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="btn">Realizar Compra</button>
            </form>
        </section>

        <section>
            <h2>Pontuação no Sorteio</h2>
            <p>Total de Pontos: <?php echo number_format($pontos, 2, ',', '.'); ?></p>
        </section>

        <a href="index.php" class="btn">Voltar ao Início</a>
    </main>
</body>
</html>

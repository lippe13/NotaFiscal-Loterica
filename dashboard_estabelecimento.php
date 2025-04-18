<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['estabelecimento_id'])) {
    header('Location: login_estabelecimento.php');
    exit;
}

$estabelecimentoId = $_SESSION['estabelecimento_id'];

try {
    
    $stmt = $pdo->prepare("SELECT * FROM Estabelecimento WHERE idEstabelecimento = :id");
    $stmt->execute(['id' => $estabelecimentoId]);
    $estabelecimento = $stmt->fetch();

    if (!$estabelecimento) {
        echo "Estabelecimento não encontrado.";
        exit;
    }

    $stmtVendas = $pdo->prepare("SELECT Compra.Valor, Compra.Data, User.Nome AS user_nome
                                 FROM Compra
                                 INNER JOIN User ON Compra.Compra_User = User.idUser
                                 WHERE Compra.Compra_Estabelecimento = :id");
    $stmtVendas->execute(['id' => $estabelecimentoId]);
    $vendas = $stmtVendas->fetchAll();
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estabelecimento</title>
    <link rel="stylesheet" href="dashboard_estabelecimento.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Estabelecimento: <?= htmlspecialchars($estabelecimento['Nome']); ?></h2>
        <h3>VENDAS REALIZADAS:</h3>

        <?php if (count($vendas) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome do Usuário</th>
                        <th>Data</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vendas as $venda): ?>
                        <tr>
                            <td><?= htmlspecialchars($venda['user_nome']); ?></td>
                            <td><?= htmlspecialchars($venda['Data']); ?></td>
                            <td>R$ <?= number_format($venda['Valor'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Ainda não houve vendas neste estabelecimento.</p>
        <?php endif; ?>

        <a href="index.php" class="btn voltar">Voltar à Tela Inicial</a>

    </div>
</body>
</html>

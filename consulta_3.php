<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataInicio = $_POST['data_inicio']; 
    $dataFim = $_POST['data_fim']; 

    try {
        $stmt = $pdo->prepare("
            SELECT SUM(c.Valor) AS TotalVendas
            FROM Compra c
            WHERE c.Data BETWEEN :data_inicio AND :data_fim
        ");
        $stmt->execute(['data_inicio' => $dataInicio, 'data_fim' => $dataFim]);
        $totalVendas = $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta 3 - Montante Vendido</title>
    <link rel="stylesheet" href="consulta_3.css">
</head>
<body>
    <header>
        <h1>Consultas - Exc 3</h1>
    </header>

    <main>
        <section>
            <h2>Selecione o Período</h2>
            <form method="POST">
                <label for="data_inicio">Data de Início:</label>
                <input type="date" name="data_inicio" id="data_inicio" required>

                <label for="data_fim">Data de Fim:</label>
                <input type="date" name="data_fim" id="data_fim" required>

                <button type="submit" class="btn">Consultar</button>
            </form>
        </section>

        <?php if (isset($totalVendas)): ?>
            <section>
                <h2>Resultado da Consulta</h2>
                <?php if ($totalVendas > 0): ?>
                    <p>Total de Vendas no Período: R$ <?php echo number_format($totalVendas, 2, ',', '.'); ?></p>
                <?php else: ?>
                    <p>Não houve vendas no período selecionado.</p>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <a href="consultas.php" class="btn">Voltar às Consultas</a>
    </main>
</body>
</html>

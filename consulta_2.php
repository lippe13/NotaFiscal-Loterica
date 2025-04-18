<?php
session_start();
include 'conexao.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mesSelecionado = $_POST['mes']; 

    try {
        
        $stmt = $pdo->prepare("
            SELECT e.idEstabelecimento, e.Nome, SUM(c.Valor) AS TotalVendas
            FROM Estabelecimento e
            LEFT JOIN Compra c ON e.idEstabelecimento = c.Compra_Estabelecimento AND MONTH(c.Data) = :mes
            GROUP BY e.idEstabelecimento
        ");
        $stmt->execute(['mes' => $mesSelecionado]);
        $estabelecimentos = $stmt->fetchAll();
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
    <title>Consulta 2 - Estabelecimentos e Vendas</title>
    <link rel="stylesheet" href="consulta_2.css"> 
</head>
<body>
    <header>
        <h1>Consultas - Exc 2</h1>
    </header>

    <main>
        <section>
            <h2>Selecione o Mês</h2>
            <form method="POST">
                <label for="mes">Mês:</label>
                <select name="mes" id="mes" required>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
                <button type="submit" class="btn">Consultar</button>
            </form>
        </section>

        <?php if (isset($estabelecimentos)): ?>
            <section>
                <h2>Resultado da Consulta</h2>
                <?php if ($estabelecimentos): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome do Estabelecimento</th>
                                <th>Total de Vendas (R$)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($estabelecimentos as $estabelecimento): ?>
                                <?php if ($estabelecimento['TotalVendas'] > 0): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($estabelecimento['Nome']); ?></td>
                                        <td><?php echo number_format($estabelecimento['TotalVendas'], 2, ',', '.'); ?></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2"><?php echo htmlspecialchars($estabelecimento['Nome']); ?> - Esse estabelecimento não vendeu esse mês.</td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Não há vendas realizadas neste mês para os estabelecimentos selecionados.</p>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <a href="consultas.php" class="btn">Voltar às Consultas</a>
    </main>
</body>
</html>

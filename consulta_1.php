<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mesSelecionado = $_POST['mes']; 

    try {

        $stmt = $pdo->prepare("
            SELECT u.idUser, u.Nome, SUM(c.Valor) AS TotalCompras, SUM(c.Valor) AS Pontuacao
            FROM User u
            LEFT JOIN Compra c ON u.idUser = c.Compra_User AND MONTH(c.Data) = :mes
            GROUP BY u.idUser
        ");
        $stmt->execute(['mes' => $mesSelecionado]);
        $usuarios = $stmt->fetchAll();
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
    <title>Consulta 1 - Usuários e Compras</title>
    <link rel="stylesheet" href="consulta_1.css"> 
</head>
<body>
    <header>
        <h1>Consultas - Exc 1</h1>
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

        <?php if (isset($usuarios)): ?>
            <section>
                <h2>Resultado da Consulta</h2>
                <?php if ($usuarios): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Total de Compras (R$)</th>
                                <th>Pontuação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <?php if ($usuario['TotalCompras'] > 0): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($usuario['Nome']); ?></td>
                                        <td><?php echo number_format($usuario['TotalCompras'], 2, ',', '.'); ?></td>
                                        <td><?php echo number_format($usuario['Pontuacao'], 2, ',', '.'); ?></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3"><?php echo htmlspecialchars($usuario['Nome']); ?> - Não fez compras nesse mês.</td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Não há compras realizadas neste mês para os usuários selecionados.</p>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <a href="consultas.php" class="btn">Voltar às Consultas</a>
    </main>
</body>
</html>

<?php
session_start();
include 'conexao.php';

$vencedor = null;
$valor_total_compras = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $stmt_compras = $pdo->query("SELECT SUM(Valor) AS total_compras FROM Compra");
    $total_compras = $stmt_compras->fetchColumn();

    $stmt_usuarios_compras = $pdo->query("
        SELECT idUser, Nome, Pontos FROM User WHERE Pontos > 0");
    $usuarios_compras = $stmt_usuarios_compras->fetchAll();

    if (empty($usuarios_compras) || !$total_compras) {
        $vencedor = "Não há usuários ou vendas para o sorteio.";
    } else {
        $pontos_totais = 0;
        foreach ($usuarios_compras as $usuario) {
            $pontos_totais += $usuario['Pontos'];
        }

        $random_value = rand(0, $pontos_totais);
        $acumulado = 0;

        foreach ($usuarios_compras as $usuario) {
            $acumulado += $usuario['Pontos'];
            if ($random_value <= $acumulado) {
                $vencedor = $usuario['Nome'];
                $valor_total_compras = $total_compras;
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorteio</title>
    <link rel="stylesheet" href="sorteio.css">
</head>
<body>
    <div class="sorteio-container">
        <h1>Sorteio de Compras</h1>
        
        <form method="POST" action="sorteio.php">
            <button type="submit" class="btn" name="sorteio">Fazer Sorteio</button>
        </form>

        <?php if ($vencedor): ?>
            <div class="resultado">
                <h2>Resultado do Sorteio</h2>
                <?php if ($vencedor == "Não há usuários ou vendas para o sorteio."): ?>
                    <p><?php echo $vencedor; ?></p>
                <?php else: ?>
                    <p><strong><?php echo $vencedor; ?></strong> ganhou R$ <?php echo number_format($valor_total_compras, 2, ',', '.'); ?>!</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <a href="index.php" class="btn voltar">Voltar à Tela Inicial</a>
    </div>
</body>
</html>

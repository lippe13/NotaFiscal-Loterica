<?php
session_start();
include 'conexao.php';

$usuarios = []; 
$user = null;
$compras = [];


try {
    $stmtUsuarios = $pdo->query("SELECT idUser, Nome FROM User");
    $usuarios = $stmtUsuarios->fetchAll();
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUser = $_POST['id_user'];
    $dataInicio = $_POST['data_inicio'];
    $dataFim = $_POST['data_fim'];

    try {
        
        $stmtUser = $pdo->prepare("SELECT * FROM User WHERE idUser = :idUser");
        $stmtUser->execute(['idUser' => $idUser]);
        $user = $stmtUser->fetch();

        $stmtCompras = $pdo->prepare("
            SELECT c.Valor, c.Data, e.Nome AS Estabelecimento
            FROM Compra c
            JOIN Estabelecimento e ON c.Compra_Estabelecimento = e.idEstabelecimento
            WHERE c.Compra_User = :idUser AND c.Data BETWEEN :data_inicio AND :data_fim
        ");
        $stmtCompras->execute(['idUser' => $idUser, 'data_inicio' => $dataInicio, 'data_fim' => $dataFim]);
        $compras = $stmtCompras->fetchAll();
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
    <title>Consulta 4 - Dados e Compras do Usuário</title>
    <link rel="stylesheet" href="consulta_4.css"> 
</head>
<body>
    <header>
        <h1>Consultas - Exc 4</h1>
    </header>

    <main>
        <section>
            <h2>Selecione o Usuário e o Período</h2>
            <form method="POST">
                <label for="id_user">Usuário:</label>
                <select name="id_user" id="id_user" required>
                    <option value="">Selecione um usuário</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?php echo $usuario['idUser']; ?>"
                            <?php echo isset($idUser) && $idUser == $usuario['idUser'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($usuario['Nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="data_inicio">Data de Início:</label>
                <input type="date" name="data_inicio" id="data_inicio" required>

                <label for="data_fim">Data de Fim:</label>
                <input type="date" name="data_fim" id="data_fim" required>

                <button type="submit" class="btn">Consultar</button>
            </form>
        </section>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user): ?>
            <section>
                <h2>Dados do Usuário</h2>
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($user['Nome']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
                <p><strong>Celular:</strong> <?php echo htmlspecialchars($user['Celular']); ?></p>

                <h3>Compras no Período</h3>
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
                    <p>Esse usuário não fez compras nesse período.</p>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <a href="consultas.php" class="btn">Voltar às Consultas</a>
    </main>
</body>
</html>

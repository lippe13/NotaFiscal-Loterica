<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>
    <link rel="stylesheet" href="consultas.css">
</head>
<body>
    <header>
        <h1>Página de Consultas</h1>
    </header>

    <main>
        <section>
            <h2>Consultas Disponíveis</h2>
            <ul>
                <li><a href="consulta_1.php" class="btn">Consulta 1</a></li>
                <li><a href="consulta_2.php" class="btn">Consulta 2</a></li>
                <li><a href="consulta_3.php" class="btn">Consulta 3</a></li>
                <li><a href="consulta_4.php" class="btn">Consulta 4</a></li>
            </ul>
        </section>

        <a href="index.php" class="btn">Voltar à Tela Inicial</a>
    </main>
</body>
</html>

<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'user') {
    $idUser = $_SESSION['user_id'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];
    $idEstabelecimento = $_POST['estabelecimento'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO Compra (Valor, Data, Compra_User, Compra_Estabelecimento) 
            VALUES (:valor, :data, :user, :estabelecimento)
        ");
        $stmt->execute([
            'valor' => $valor,
            'data' => $data,
            'user' => $idUser,
            'estabelecimento' => $idEstabelecimento
        ]);

        header('Location: user_dashboard.php');
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    header('Location: login.php');
    exit();
}
?>

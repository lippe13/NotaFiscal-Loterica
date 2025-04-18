<?php
session_start();
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    try {
        if ($tipo === 'adm') {
            $stmt = $pdo->prepare("SELECT * FROM ADM WHERE CPF = :cpf AND Senha = :senha");
        } else {
            $stmt = $pdo->prepare("SELECT * FROM User WHERE CPF = :cpf AND Senha = :senha");
        }

        $stmt->execute(['cpf' => $cpf, 'senha' => $senha]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user_type'] = $tipo;
            $_SESSION['user_name'] = $user['Nome'];
            $_SESSION['user_id'] = ($tipo === 'adm') ? $user['idADM'] : $user['idUser'];

            if ($tipo === 'adm') {
                header('Location: adm_dashboard.php');
            } else {
                header('Location: user_dashboard.php');
            }
            exit();
        } else {
            echo "<p>CPF/Senha/Cargo incorreto(s)! <a href='login.php'>Tente novamente</a></p>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

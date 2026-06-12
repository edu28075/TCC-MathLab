<?php
session_start();
include("config/conexao.php");

if(isset($_POST['nome'], $_POST['email'], $_POST['senha'])){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome,email,senha) VALUES ('$nome','$email','$senha')";

    if($conn->query($sql)){
        // Salva informações do usuário na sessão
        $_SESSION['usuario'] = $nome;
        $_SESSION['id_usuario'] = $conn->insert_id; // pega ID do novo usuário
        $_SESSION['tipo'] = 'aluno';

        header("Location: index.php");
        exit();
    }else{
        $erro = "Erro ao cadastrar: ".$conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro - MathStudy</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="login">
<h2>Cadastro</h2>
<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="senha" placeholder="Senha" required><br><br>
    <button type="submit">Cadastrar</button>
</form>
<?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<p>Já tem conta? <a href="login.php">Login</a></p>
</div>
</body>
</html>
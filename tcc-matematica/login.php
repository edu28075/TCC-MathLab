<?php
session_start();
include("config/conexao.php");

if(isset($_POST['email'], $_POST['senha'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if(password_verify($senha, $user['senha'])){
            // Salva informações do usuário na sessão
            $_SESSION['usuario'] = $user['nome'];
            $_SESSION['id_usuario'] = $user['id'];
            $_SESSION['tipo'] = $user['tipo'];

            // Redireciona conforme tipo
            if($user['tipo'] == 'admin'){
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $erro = "Senha incorreta";
        }
    } else {
        $erro = "Usuário não encontrado";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - MathStudy</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="login">
<h2>Login</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="senha" placeholder="Senha" required><br><br>
    <button type="submit">Entrar</button>
</form>
<?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
</div>
</body>
</html>
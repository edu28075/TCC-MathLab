<?php
session_start();
include("config/conexao.php");

// Protege a página: só admin pode acessar
if(!isset($_SESSION['usuario']) || $_SESSION['tipo'] != 'admin'){
    header("Location: index.php");
    exit();
}

// Mensagem de sucesso/erro
$mensagem = "";

// Adicionar usuário
if(isset($_POST['acao']) && $_POST['acao'] == 'adicionar_usuario'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $tipo = $_POST['tipo'];
    $sql = "INSERT INTO usuarios (nome,email,senha,tipo) VALUES ('$nome','$email','$senha','$tipo')";
    if($conn->query($sql)){
        $mensagem = "Usuário adicionado com sucesso!";
    }else{
        $mensagem = "Erro ao adicionar usuário: ".$conn->error;
    }
}

// Deletar usuário
if(isset($_GET['del_user'])){
    $id = $_GET['del_user'];
    $sql = "DELETE FROM usuarios WHERE id=$id";
    $conn->query($sql);
    $mensagem = "Usuário deletado!";
}

// Buscar todos os usuários
$usuarios = $conn->query("SELECT id,nome,email,tipo FROM usuarios");

// Buscar todas as questões
$questoes = $conn->query("SELECT id,tema,nivel,enunciado FROM questoes");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador - MathStudy</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body{font-family:Arial,sans-serif;background:#f0f2f5;padding:20px;}
        header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;}
        nav a{margin-left:20px;text-decoration:none;color:#2575fc;font-weight:bold;}
        h1{margin-bottom:20px;}
        table{width:100%;border-collapse:collapse;margin-bottom:30px;}
        table, th, td{border:1px solid #ccc;}
        th, td{padding:10px;text-align:left;}
        .btn{padding:6px 12px;color:white;text-decoration:none;border-radius:5px;}
        .btn-editar{background:#f0ad4e;}
        .btn-deletar{background:#d9534f;}
        .btn-adicionar{background:#5cb85c;}
        form{margin-bottom:20px;}
        input, select{padding:6px;margin-right:10px;}
        .mensagem{margin-bottom:20px;color:green;}
    </style>
</head>
<body>

<header>
    <h2>Painel do Administrador</h2>
    <nav>
        <a href="index.php">Início</a>
        <a href="logout.php">Sair</a>
    </nav>
</header>

<h1>Bem-vindo, <?php echo $_SESSION['usuario']; ?>!</h1>

<?php if($mensagem != "") echo "<p class='mensagem'>$mensagem</p>"; ?>

<h2>Gerenciar Usuários</h2>

<!-- Formulário adicionar usuário -->
<form method="POST">
    <input type="hidden" name="acao" value="adicionar_usuario">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <select name="tipo">
        <option value="aluno">Aluno</option>
        <option value="admin">Administrador</option>
    </select>
    <button type="submit" class="btn btn-adicionar">Adicionar Usuário</button>
</form>

<!-- Tabela de usuários -->
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Tipo</th>
        <th>Ações</th>
    </tr>
    <?php while($u = $usuarios->fetch_assoc()): ?>
    <tr>
        <td><?php echo $u['id']; ?></td>
        <td><?php echo $u['nome']; ?></td>
        <td><?php echo $u['email']; ?></td>
        <td><?php echo $u['tipo']; ?></td>
        <td>
            <a href="admin.php?del_user=<?php echo $u['id']; ?>" class="btn btn-deletar" onclick="return confirm('Deseja deletar este usuário?')">Deletar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Gerenciar Questões</h2>

<!-- Aqui você pode adicionar um formulário para adicionar questões -->
<p>Para adicionar, editar ou remover questões, utilize os links abaixo:</p>
<table>
    <tr>
        <th>ID</th>
        <th>Tema</th>
        <th>Nível</th>
        <th>Enunciado</th>
        <th>Ações</th>
    </tr>
    <?php while($q = $questoes->fetch_assoc()): ?>
    <tr>
        <td><?php echo $q['id']; ?></td>
        <td><?php echo $q['tema']; ?></td>
        <td><?php echo $q['nivel']; ?></td>
        <td><?php echo substr($q['enunciado'],0,50).'...'; ?></td>
        <td>
            <a href="editar_questao.php?id=<?php echo $q['id']; ?>" class="btn btn-editar">Editar</a>
            <a href="deletar_questao.php?id=<?php echo $q['id']; ?>" class="btn btn-deletar" onclick="return confirm('Deseja deletar esta questão?')">Deletar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
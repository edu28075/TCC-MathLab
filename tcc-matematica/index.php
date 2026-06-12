<?php
session_start();
include("config/conexao.php");

$status = null;

if(isset($_SESSION['id_usuario'])){
    $id_usuario = intval($_SESSION['id_usuario']);

    $sql = "SELECT xp_total, nivel, objetivos FROM usuarios WHERE id = $id_usuario";
    $result = $conn->query($sql);
    $status = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>MathLab</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>
<h2>MathLab</h2>

<nav>
<a href="index.php">Início</a>

<?php if(isset($_SESSION['usuario'])): ?>
<a href="logout.php">Sair</a>
<?php else: ?>
<a href="login.php">Login</a>
<?php endif; ?>

</nav>
</header>

<div class="layout">

<div class="conteudo">

<h1 class="titulo">Conteúdos de Matemática</h1>

<div class="grid">

<a href="dificuldade.php?tema=fracoes" class="card">
<img src="img/fracoes.png">
<h3>Frações</h3>
</a>

<a href="dificuldade.php?tema=porcentagem" class="card">
<img src="img/porcentagem.png">
<h3>Porcentagem</h3>
</a>

<a href="dificuldade.php?tema=equacoes" class="card">
<img src="img/equacoes.png">
<h3>Equações</h3>
</a>

<a href="dificuldade.php?tema=geometria" class="card">
<img src="img/geometria.png">
<h3>Geometria</h3>
</a>

<a href="dificuldade.php?tema=inteiros" class="card">
<img src="img/inteiros.png">
<h3>Números Inteiros</h3>
</a>

<a href="dificuldade.php?tema=potenciacao" class="card">
<img src="img/potenciacao.png">
<h3>Potenciação</h3>
</a>

</div>

</div>

<?php if(isset($_SESSION['usuario']) && $status): ?>

<div class="sidebar">

<h3><?php echo $_SESSION['usuario']; ?></h3>

<div class="nivel">
Nível <?php echo $status['nivel']; ?>
</div>

<div class="xp">

<div class="barra">
<div class="progresso" style="width:<?php echo ($status['xp_total'] % 100); ?>%"></div>
</div>

<p><?php echo $status['xp_total']; ?> XP</p>

</div>

<p><strong>Objetivo:</strong></p>
<p><?php echo $status['objetivos'] ?? "Nenhum"; ?></p>

<h4>Conquistas</h4>

<div class="conquistas">

<?php
$sql = "SELECT c.nome, c.icone
FROM usuario_conquistas uc
JOIN conquistas c ON c.id = uc.conquista_id
WHERE uc.usuario_id = $id_usuario";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
?>

<div class="conquista-item">
    <img src="img/conquistas/<?php echo $row['icone']; ?>">
    <p><?php echo $row['nome']; ?></p>
</div>

<?php } ?>

</div>

</div>

<?php endif; ?>

</div>

</body>
</html>
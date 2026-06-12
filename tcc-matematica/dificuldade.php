<?php

if(!isset($_GET['tema'])){
    header("Location: index.php");
    exit();
}

$tema = $_GET['tema'];

?>

<!DOCTYPE html>
<html>
<head>
<title>Dificuldade</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<h1 class="titulo">Escolha a dificuldade</h1>

<div class="grid">

<a href="exercicios.php?tema=<?php echo $tema ?>&nivel=facil" class="card">
<h3>Fácil</h3>
</a>

<a href="exercicios.php?tema=<?php echo $tema ?>&nivel=medio" class="card">
<h3>Médio</h3>
</a>

<a href="exercicios.php?tema=<?php echo $tema ?>&nivel=dificil" class="card">
<h3>Difícil</h3>
</a>

</div>

</body>
</html>
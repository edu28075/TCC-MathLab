<?php

session_start();

$pontos = $_SESSION['pontos'];

session_destroy();

?>

<!DOCTYPE html>
<html>

<head>
<title>Resultado</title>
</head>

<body>

<h2>Resultado final</h2>

<p>Você acertou <?php echo $pontos ?> de 5 questões.</p>

<a href="index.php">Voltar ao início</a>

</body>
</html>
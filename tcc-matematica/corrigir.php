<?php

include("config/conexao.php");

$tema = $_GET['tema'] ?? '';
$nivel = $_GET['nivel'] ?? '';

$sql = "SELECT * FROM questoes
WHERE tema='$tema'
AND nivel='$nivel'
ORDER BY RAND()
LIMIT 5";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
<title>Exercícios</title>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="login">

<h2>Responda as questões</h2>

<form action="corrigir.php" method="POST">

<?php

while($questao = $result->fetch_assoc()){

$qid = $questao['id'];

echo "<h3>".$questao['enunciado']."</h3>";

$sql_alt = "SELECT * FROM alternativas
WHERE questao_id=$qid";

$alts = $conn->query($sql_alt);

while($alt = $alts->fetch_assoc()){

?>

<label>

<input type="radio" name="resposta[<?php echo $qid ?>]" value="<?php echo $alt['id'] ?>" required>

<?php echo $alt['texto']; ?>

</label>

<br><br>

<?php

}

echo "<hr>";

}

?>

<button type="submit">Finalizar</button>

</form>

</div>

</body>
</html>
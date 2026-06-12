<?php

include("config/conexao.php");

$sql = "SELECT * FROM questoes
WHERE tipo='multipla'
ORDER BY RAND()
LIMIT 1";

$result = $conn->query($sql);

$questao = $result->fetch_assoc();

$qid = $questao['id'];

$sql_alt = "SELECT * FROM alternativas
WHERE questao_id = $qid";

$alts = $conn->query($sql_alt);

?>

<!DOCTYPE html>

<html>

<head>

<title>Teste de Questão</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<h1>Exercício</h1>

<h2>

<?php echo $questao['enunciado']; ?>

</h2>

<?php

if($questao['imagem']){
?>

<img src="img/<?php echo $questao['imagem']; ?>">

<?php
}
?>

<form>

<?php

while($alt = $alts->fetch_assoc()){

?>

<label>

<input type="radio" name="resposta">

<?php echo $alt['texto']; ?>

</label>

<br><br>

<?php

}

?>

<button>Responder</button>

</form>

</body>

</html>
<form method="post">

Tema:
<select name="tema">
<option>fracoes</option>
<option>porcentagem</option>
<option>equacoes</option>
</select>

<br><br>

Nivel:
<select name="nivel">
<option>facil</option>
<option>medio</option>
<option>dificil</option>
</select>

<br><br>

Pergunta:

<input type="text" name="pergunta">

<br><br>

Resposta:

<input type="text" name="resposta">

<br><br>

<button type="submit">Salvar</button>

</form>

<?php

$conn = new mysqli("localhost","root","","tcc_matematica");

$tema = $_POST['tema'];
$nivel = $_POST['nivel'];
$pergunta = $_POST['pergunta'];
$resposta = $_POST['resposta'];

$sql = "INSERT INTO exercicios (tema,nivel,pergunta,resposta)
VALUES ('$tema','$nivel','$pergunta','$resposta')";

$conn->query($sql);

?>
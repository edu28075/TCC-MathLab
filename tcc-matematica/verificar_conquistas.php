<?php

function verificarConquistas($conn,$usuario_id,$xp){

$sql = "SELECT * FROM conquistas WHERE xp_requisito <= $xp";
$result = $conn->query($sql);

while($conquista = $result->fetch_assoc()){

$conquista_id = $conquista['id'];

$check = $conn->query("
SELECT * FROM usuario_conquistas
WHERE usuario_id = $usuario_id
AND conquista_id = $conquista_id
");

if($check->num_rows == 0){

$conn->query("
INSERT INTO usuario_conquistas (usuario_id,conquista_id)
VALUES ($usuario_id,$conquista_id)
");

}

}

}
?>
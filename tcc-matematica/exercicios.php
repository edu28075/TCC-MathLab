<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

include("config/conexao.php");

$id_usuario = intval($_SESSION['id_usuario']);

// ==========================
// TEMA E NIVEL
// ==========================
if(isset($_GET['tema']) && isset($_GET['nivel'])){
    $_SESSION['tema'] = $_GET['tema'];
    $_SESSION['nivel'] = $_GET['nivel'];

    unset($_SESSION['questoes']);
    unset($_SESSION['indice']);
    unset($_SESSION['xp_prova']);
    unset($_SESSION['streak']);
    unset($_SESSION['id_prova']);
}

if(!isset($_SESSION['tema']) || !isset($_SESSION['nivel'])){
    echo "Erro de sessão.";
    exit();
}

$tema = $_SESSION['tema'];
$nivel = $_SESSION['nivel'];

// ==========================
// INICIAR PROVA
// ==========================
if(!isset($_SESSION['questoes'])){

    $_SESSION['id_prova'] = time();

    $sql = "SELECT id, tipo FROM questoes
            WHERE tema='$tema' AND nivel='$nivel'
            ORDER BY RAND() LIMIT 5";

    $result = $conn->query($sql);

    $questoes = [];

    while($row = $result->fetch_assoc()){
        $questoes[] = $row;
    }

    if(empty($questoes)){
        echo "Nenhuma questão encontrada.";
        exit();
    }

    $_SESSION['questoes'] = $questoes;
    $_SESSION['indice'] = 0;
    $_SESSION['xp_prova'] = 0;
    $_SESSION['feedback'] = '';
    $_SESSION['acertos_prova'] = 0;
    $_SESSION['erros_prova'] = 0;
    $_SESSION['streak'] = 0;
}

// ==========================
// RESPOSTA
// ==========================
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $indice = $_SESSION['indice'];
    $questao_id = $_SESSION['questoes'][$indice]['id'];
    $tipo = $_SESSION['questoes'][$indice]['tipo'];

    $acertou = 0;
    $xp = 0;

    $resposta = $_POST['resposta'] ?? $_POST['resposta_aberta'] ?? null;

    if($resposta === null){
        $_SESSION['indice']++;
        header("Location: exercicios.php");
        exit();
    }

    // MULTIPLA
    if($tipo == 'multipla'){
        $resposta = intval($resposta);

        $r = $conn->query("SELECT correta FROM alternativas WHERE id=$resposta");
        $d = $r->fetch_assoc();

        if($d && $d['correta'] == 1){
            $acertou = 1;
        }

    } else {
        $resposta = str_replace(',', '.', strtolower(trim($resposta)));

        $r = $conn->query("SELECT resposta FROM respostas_abertas WHERE questao_id=$questao_id");
        $d = $r->fetch_assoc();

        if($d){
            $certa = str_replace(',', '.', strtolower(trim($d['resposta'])));

            if(is_numeric($resposta) && is_numeric($certa)){
                if(abs($resposta - $certa) < 0.0001){
                    $acertou = 1;
                }
            } else {
                if($resposta == $certa){
                    $acertou = 1;
                }
            }
        }
    }

    // XP
    if($nivel == 'facil') $xp = $acertou ? 1 : 0;
    if($nivel == 'medio') $xp = $acertou ? 3 : 0;
    if($nivel == 'dificil') $xp = $acertou ? 5 : 0;

    $_SESSION['xp_prova'] += $xp;

    if($acertou){
        $_SESSION['acertos_prova']++;
        $_SESSION['streak']++;
    } else {
        $_SESSION['erros_prova']++;
        $_SESSION['streak'] = 0;
    }

    // =========================
    // SALVAR PROGRESSO
    // =========================
    $stmt = $conn->prepare("
        INSERT INTO progresso 
        (id_usuario, id_questao, id_prova, acertou, xp_ganho, nivel, tema) 
        VALUES (?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "iiiisss",
        $id_usuario,
        $questao_id,
        $_SESSION['id_prova'],
        $acertou,
        $xp,
        $nivel,
        $tema
    );

    $stmt->execute();

    // =========================
    // ATUALIZAR USUARIO
    // =========================
    $conn->query("UPDATE usuarios SET xp_total = xp_total + $xp WHERE id=$id_usuario");

    // =========================
    // ESTATÍSTICAS
    // =========================
    $acertos = $conn->query("SELECT COUNT(*) as t FROM progresso WHERE id_usuario=$id_usuario AND acertou=1")->fetch_assoc()['t'];
    $erros = $conn->query("SELECT COUNT(*) as t FROM progresso WHERE id_usuario=$id_usuario AND acertou=0")->fetch_assoc()['t'];
    $temas = $conn->query("SELECT COUNT(DISTINCT tema) as t FROM progresso WHERE id_usuario=$id_usuario")->fetch_assoc()['t'];

    $provas_perfeitas = $conn->query("
        SELECT COUNT(*) as total FROM (
            SELECT id_prova
            FROM progresso
            WHERE id_usuario=$id_usuario
            GROUP BY id_prova
            HAVING SUM(acertou)=5
        ) t
    ")->fetch_assoc()['total'];

    // =========================
    // CONQUISTAS COMPLETAS
    // =========================
    $_SESSION['nova_conquista'] = [];

    $conqs = $conn->query("SELECT * FROM conquistas");

    while($c = $conqs->fetch_assoc()){

        $ganhou = false;

        switch($c['tipo']){

            case 'acerto':
                if($acertos >= $c['valor']) $ganhou = true;
            break;

            case 'erro':
                if($erros >= $c['valor']) $ganhou = true;
            break;

            case 'tema_variedade':
                if($temas >= $c['valor']) $ganhou = true;
            break;

            case 'perfeito':
                if($provas_perfeitas >= $c['valor']) $ganhou = true;
            break;

            case 'streak':
                if($_SESSION['streak'] >= $c['valor']) $ganhou = true;
            break;

            case 'prova':
                $total = $conn->query("SELECT COUNT(DISTINCT id_prova) as t FROM progresso WHERE id_usuario=$id_usuario")->fetch_assoc()['t'];
                if($total >= $c['valor']) $ganhou = true;
            break;

            case 'nivel':
                $xp_total = $conn->query("SELECT xp_total FROM usuarios WHERE id=$id_usuario")->fetch_assoc()['xp_total'];
                $nivel_usuario = floor($xp_total / 10);
                if($nivel_usuario >= $c['valor']) $ganhou = true;
            break;

            case 'tema_geometria':
            case 'tema_potencia':
            case 'tema_funcoes':
            case 'tema_equacoes':

                $tema_nome = str_replace('tema_', '', $c['tipo']);

                $total = $conn->query("
                    SELECT COUNT(*) as t 
                    FROM progresso 
                    WHERE id_usuario=$id_usuario 
                    AND tema='$tema_nome'
                    AND acertou=1
                ")->fetch_assoc()['t'];

                if($total >= $c['valor']) $ganhou = true;
            break;

            case 'dificil':
                $total = $conn->query("
                    SELECT COUNT(DISTINCT id_prova) as t
                    FROM progresso
                    WHERE id_usuario=$id_usuario
                    AND nivel='dificil'
                ")->fetch_assoc()['t'];

                if($total >= $c['valor']) $ganhou = true;
            break;

            case 'especial':

                if($c['nome'] == 'Equilíbrio'){
                    if($_SESSION['acertos_prova'] >= 1 && $_SESSION['erros_prova'] >= 1){
                        $ganhou = true;
                    }
                }

                if($c['nome'] == 'Explorador'){
                    $niveis = $conn->query("
                        SELECT COUNT(DISTINCT nivel) as t
                        FROM progresso
                        WHERE id_usuario=$id_usuario
                    ")->fetch_assoc()['t'];

                    if($niveis >= 3){
                        $ganhou = true;
                    }
                }

                if($c['nome'] == 'Viciado'){
                    $total = $conn->query("
                        SELECT COUNT(*) as t
                        FROM progresso
                        WHERE id_usuario=$id_usuario
                    ")->fetch_assoc()['t'];

                    if($total >= $c['valor']) $ganhou = true;
                }

                if($c['nome'] == 'Mito'){
                    $total = $conn->query("
                        SELECT COUNT(*) as t FROM usuario_conquistas
                        WHERE usuario_id=$id_usuario
                    ")->fetch_assoc()['t'];

                    if($total >= 41){
                        $ganhou = true;
                    }
                }

            break;
        }

        if($ganhou){
            $check = $conn->query("SELECT * FROM usuario_conquistas 
                                  WHERE usuario_id=$id_usuario 
                                  AND conquista_id=".$c['id']);

            if($check->num_rows == 0){
                $stmt = $conn->prepare("INSERT INTO usuario_conquistas (usuario_id, conquista_id) VALUES (?,?)");
                $stmt->bind_param("ii", $id_usuario, $c['id']);
                $stmt->execute();

                $_SESSION['nova_conquista'][] = $c['nome'];
            }
        }
    }

    $_SESSION['feedback'] = $acertou ? "Acertou! +$xp XP" : "Errou!";
    $_SESSION['indice']++;

    header("Location: exercicios.php");
    exit();
}

// ==========================
// FINAL
// ==========================
if($_SESSION['indice'] >= 5){
    echo "<h2>Resultado final</h2>";
    echo "<p>XP: ".$_SESSION['xp_prova']."</p>";
    echo "<a href='index.php'>Voltar</a>";
    exit();
}

// ==========================
// QUESTAO
// ==========================
$indice = $_SESSION['indice'];
$qid = $_SESSION['questoes'][$indice]['id'];

$questao = $conn->query("SELECT * FROM questoes WHERE id=$qid")->fetch_assoc();
$alts = $conn->query("SELECT * FROM alternativas WHERE questao_id=$qid");
?>

<!DOCTYPE html>
<html>
<head>
<title>Exercícios</title>
<link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<?php if(!empty($_SESSION['nova_conquista'])){ ?>
<div class="popup-container">
<?php $i = 0; foreach($_SESSION['nova_conquista'] as $nome){ ?>
    <div class="popup" style="animation-delay: <?php echo $i * 0.5; ?>s;">
        <div>
            <strong>🏆 Conquista desbloqueada!</strong><br>
            <?php echo $nome; ?>
        </div>
    </div>
<?php $i++; } ?>
</div>
<?php unset($_SESSION['nova_conquista']); } ?>

<div class="login">

<h3>Questão <?php echo $indice+1 ?> de 5</h3>
<p>XP: <?php echo $_SESSION['xp_prova']; ?></p>

<?php if($_SESSION['feedback']){
    echo "<p><b>".$_SESSION['feedback']."</b></p>";
    $_SESSION['feedback'] = '';
} ?>

<h2><?php echo $questao['enunciado']; ?></h2>

<form method="POST">

<?php if($questao['tipo']=='multipla'){
    while($alt = $alts->fetch_assoc()){ ?>
        <label>
            <input type="radio" name="resposta" value="<?php echo $alt['id']; ?>">
            <?php echo $alt['texto']; ?>
        </label><br><br>
<?php }} else { ?>
    <input type="text" name="resposta_aberta"><br><br>
<?php } ?>

<button type="submit">Responder</button>

</form>
</div>

<script>
document.querySelectorAll('.popup').forEach((p,i)=>{
    setTimeout(()=>{
        p.classList.add('hide');
    }, 3000 + (i * 500));

    p.addEventListener('click',()=>p.remove());
});
</script>

</body>
</html>
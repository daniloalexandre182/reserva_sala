
<?php
include ('etc/conexao.php');

$hoje = date('d-m-Y');
$translate = array(
    0 => "Dom",
    1 => "Seg",
    2 => "Ter",
    3 => "Qua",
    4 => "Qui",
    5 => "Sex",
    6 => "Sab",
    7 => "Dom",
    8 => "Seg",
    9 => "Ter",
    10 => "Qua",
    11 => "Qui",
    12 => "Sex",
    13 => "Sab",
);

$data = new DateTime($hoje);     // Pega a data de hoje
$diaN = date( "w", strtotime($data->format('Y-m-d'))); // Dia da semana, começa em 0 com domingo, 1 para segunda...
$data->modify('-' . $diaN . ' day');
// Pulo primeiro domingo
$data->modify('+1 day');

$cabecario1 = '';
$cabecario2 = '';

for($i=0;$i<=11;$i++) {
    //echo $data->format('d/m/Y') . ' - ' .  $translate[$data->format('w')] . "<br>";
    $datasSQL[$i] = $data->format('Y-m-d');

    if($i == 0)
        $cabecario1 .= '<th>'.$data->format('d/m').'<br><small>Segunda</small></th>';
    else if($i == 1)
        $cabecario1 .= '<th>'.$data->format('d/m').'<br><small>Terça</small></th>';
    else if($i == 2)
        $cabecario1 .= '<th>'.$data->format('d/m').'<br><small>Quarta</small></th>';
    else if($i == 3)
        $cabecario1 .= '<th>'.$data->format('d/m').'<br><small>Quinta</small></th>';
    else if($i == 4)
        $cabecario1 .= '<th>'.$data->format('d/m').'<br><small>Sexta</small></th>';
    else if($i == 7)
        $cabecario2 .= '<th>'.$data->format('d/m').'<br><small>Segunda</small></th>';
    else if($i == 8)
        $cabecario2 .= '<th>'.$data->format('d/m').'<br><small>Terça</small></th>';
    else if($i == 9)
        $cabecario2 .= '<th>'.$data->format('d/m').'<br><small>Quarta</small></th>';
    else if($i == 10)
        $cabecario2 .= '<th>'.$data->format('d/m').'<br><small>Quinta</small></th>';
    else if($i == 11)
        $cabecario2 .= '<th>'.$data->format('d/m').'<br><small>Sexta</small></th>';

    $data->modify('+1 day');
}


function salasSemanaUm($datasSQL)
{
    $sql = "SELECT *
    FROM tb_sala
    WHERE sal_ativo = 1
    ORDER BY sal_ativo DESC, sal_bloco, sal_numero;";
    $PDO = db_connect_rs();
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    
    $table = '';

    foreach($stmt as $sala)
    {
        $table .= "<tr><td>".$sala['sal_bloco']."</td><td>".$sala['sal_andar']."</td><td>".$sala['sal_numero']."</td><td>".$sala['sal_descr']."</td><td>".$sala['sal_capacidade']."</td><td>".ocupacao($sala['sal_segunda'],$datasSQL[0],$sala['sal_id'])."</td><td>".ocupacao($sala['sal_terca'],$datasSQL[1],$sala['sal_id'])."</td><td>".ocupacao($sala['sal_quarta'],$datasSQL[2],$sala['sal_id'])."</td><td>".ocupacao($sala['sal_quinta'],$datasSQL[3],$sala['sal_id'])."</td><td>".ocupacao($sala['sal_sexta'],$datasSQL[4],$sala['sal_id'])."</td></tr>";
    }
    echo $table;
}

function salasSemanaDois($datasSQL)
{
    $sql = "SELECT *
    FROM tb_sala
    WHERE sal_ativo = 1
    ORDER BY sal_ativo DESC, sal_bloco, sal_numero;";
    $PDO = db_connect_rs();
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    
    $table = '';

    foreach($stmt as $sala)
    {
        $table .= "<tr><td>".$sala['sal_bloco']."</td><td>".$sala['sal_andar']."</td><td>".$sala['sal_numero']."</td><td>".$sala['sal_descr']."</td><td>".$sala['sal_capacidade']."</td><td>".ocupacao($sala['sal_segunda'],$datasSQL[7],$sala['sal_id'])."</td><td>".ocupacao($sala['sal_terca'],$datasSQL[8],$sala['sal_id'])."</td><td>".ocupacao($sala['sal_quarta'],$datasSQL[9],$sala['sal_id'])."</td><td>".ocupacao($sala['sal_quinta'],$datasSQL[10],$sala['sal_id'])."</td><td>".ocupacao($sala['sal_sexta'],$datasSQL[11],$sala['sal_id'])."</td></tr>";
    }
    echo $table;
}

function ocupacao($ocupada,$data,$sala)
{
    if($ocupada == 1)
        return reservas($sala,$data);
    else
        return 'Ocupada';
}

function reservas($sala,$data)
{
    $sql = "SELECT res_solicitante, res_turma
    from tb_reserva
    where
    res_dtreserva = '$data'
    and res_salid = $sala
    and res_ativo = 1";
    $PDO = db_connect_rs();
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $ocupacao = $stmt->fetchAll();
    $stmt->closeCursor();
    //if($ocupacao['res_solicitante'] != "")
    if(@count($ocupacao) > 0)
    {
        if($ocupacao[0]['res_turma'] != "")
            return "<strong>".$ocupacao[0]['res_solicitante']."<br>".$ocupacao[0]['res_turma']."</strong>";
        else
            return "<strong>".$ocupacao[0]['res_solicitante']."</strong>";
    }
    else
        if($data >= date('Y-m-d'))
            return '<a href="reservar.php?sala='.$sala.'&data='.$data.'"><strong>Reservar</strong></a>';
        else
            return "Disponível";
}


include ('header.php');	
?>

    <!-- main -->
    <main class="container" id="main">
        <div class="p-3">
            <h2 class="text-center font-weight-bold">Reserva de Salas</h2>
        </div>
        
        <div class="salas">
            <table class="table table-striped text-center border">
                <thead>
                    <tr><th>Bloco</th><th>Andar</th><th>Número</th><th>Descrição</th><th>Capacidade</th>
                        <?php echo $cabecario1; ?>
                    </tr>
                </thead>
            <?php
                salasSemanaUm($datasSQL);
            ?>
            </table>
        </div>

        <div class="salas">
            <table class="table table-striped text-center border">
                <thead>
                    <tr><th>Bloco</th><th>Andar</th><th>Número</th><th>Descrição</th><th>Capacidade</th>
                        <?php echo $cabecario2; ?>
                    </tr>
                </thead>
            <?php
                salasSemanaDois($datasSQL);
            ?>
            </table>
        </div>

    </main>

    <?php
        include ('footer.php');	
    ?>
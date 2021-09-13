
<?php
// Verificador de sessão
//require "../../etc/logado.php";

include ('../etc/conexao.php');
$hoje = date('d-m-Y');

function consultaReservas()
{
    $sql = "SELECT res.*, sal_bloco, sal_numero FROM tb_reserva res
    INNER JOIN tb_sala sal on res_salid = sal_id
    WHERE res_dtreserva >= '".date('Y-m-d')."';";
    $PDO = db_connect_rs();
    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    $table = '';

    foreach($stmt as $reserva)
    {
        $data = new DateTime($reserva['res_dtreserva']); 
        $data = $data->format('d/m/Y');
        $table .= "<tr><td>".$data."</td><td>".$reserva['res_solicitante']."</td><td>".$reserva['res_turma']."</td><td>".$reserva['sal_bloco']."</td><td>".$reserva['sal_numero']."</td><td>".ativo($reserva['res_ativo']).'</td><td><a href="alterar_reserva.php?id='.$reserva['res_id'].'">Alterar</a></td></tr>';
    }
    echo $table;
}

function ativo($dado)
{
    if ($dado == 1)
        return "Sim";
    else
        return "Não";
}

include ('../../header.php');	
?>

    <!-- main -->
    <main class="container-fluid" id="main">
        <div class="p-3">
            <h2 class="text-center font-weight-bold">Reserva de salas</h2>
        </div>
        
        <div class="reservas">
            <table class="table table-striped text-center border">
                <thead>
                    <tr><th>Data</th><th>Solicitante</th><th>Turma</th><th>Bloco</th><th>Número</th><th>Ativo</th><th>Alterar</th></tr>
                </thead>
            <?php
                consultaReservas();
            ?>
            </table>
        </div>
    </main>

    <?php
        include ('../../footer.php');	
    ?>
</body>
</html>
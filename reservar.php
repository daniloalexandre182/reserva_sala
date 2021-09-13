<?php

include ('etc/conexao.php');

$sala = filter_input(INPUT_GET, 'sala', FILTER_SANITIZE_STRING);
$data = new DateTime(filter_input(INPUT_GET, 'data', FILTER_SANITIZE_STRING)); 
$data = $data->format('d/m/Y');
$datasql = filter_input(INPUT_GET, 'data', FILTER_SANITIZE_STRING);

function consultaSala($sala)
{
    $sql = "SELECT sal_numero
    FROM tb_sala
    WHERE sal_id = $sala";
    $PDO = db_connect_rs();
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $detailSala = $stmt->fetchColumn();

    return '<div class="form-group"><label for="numero">Sala:</label><input type="text" class="form-control" id="numero" name="numero" value="'.$detailSala.'" readonly></div>';
}


include ('header.php');	
?>

    <!-- main -->
    <main class="container" id="main">
        <div class="p-3">
            <h2 class="text-center font-weight-bold">Reserva de Salas</h2>
        </div>
        <form action="reservar_function.php" method="POST">
            <h2>Reservar Sala:</h2>
            <div class="form-group d-none">
                <label for="salaid">ID Sala:</label>
                <input type="text" class="form-control" id="salaid" name="salaid" value="<?php echo $sala; ?> " readonly>
            </div>
            <?php
                echo consultaSala($sala);
            ?>
            <div class="form-group">
                <label for="data">Data:</label>
                <input type="text" class="form-control" id="data" name="data" value="<?php echo $data; ?>" readonly>
            </div>
            <div class="form-group d-none">
                <input type="text" class="form-control" id="datasql" name="datasql" value="<?php echo $datasql ?>" readonly>
            </div>
            <div class="form-group">
                <label for="solicitante">Solicitante:</label>
                <input type="text" class="form-control" id="solicitante" name="solicitante" placeholder="Juliete" required>
            </div>
            <div class="form-group">
                <label for="turma">Turma:</label>
                <input type="text" class="form-control" id="turma" name="turma" placeholder="ADM 1">
            </div>
            <button type="submit" class="btn btn-primary">Gravar</button>
        </form>
            
    </main>

    <?php
        include ('footer.php');	
    ?>

<?php
// Verificador de sessão
require "../../etc/logado.php";

include ('../etc/conexao.php');

function consultaSalas()
{
    $sql = "SELECT *
    FROM tb_sala
    ORDER BY sal_ativo DESC, sal_bloco, sal_numero;";
    $PDO = db_connect_rs();
    $stmt = $PDO->prepare($sql);
    $stmt->execute();

    $table = '';

    foreach($stmt as $sala)
    {
        $table .= "<tr><td>".$sala['sal_bloco']."</td><td>".$sala['sal_andar']."</td><td>".$sala['sal_numero']."</td><td>".$sala['sal_descr']."</td><td>".$sala['sal_capacidade'].'</td><td class="bg-'.ocupacao($sala['sal_sabado']).'</td><td class="bg-'.ocupacao($sala['sal_segunda']).'</td><td class="bg-'.ocupacao($sala['sal_terca']).'</td><td class="bg-'.ocupacao($sala['sal_quarta']).'</td><td class="bg-'.ocupacao($sala['sal_quinta']).'</td><td class="bg-'.ocupacao($sala['sal_sexta']).'</td><td class="bg-'.ocupacao($sala['sal_domingo'])."</td><td>".ativo($sala['sal_ativo']).'</td><td><a href="alterar_sala.php?id='.$sala['sal_id'].'">Alterar</a></td></tr>';
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

function ocupacao($sala)
{
    if($sala == 1)
        return 'success">Livre';
    else
        return 'danger">Ocupado';
}

include ('../../header.php');	
?>

    <!-- main -->
    <main class="container-fluid" id="main">
        <div class="p-3">
            <h2 class="text-center font-weight-bold">Reserva de Salas</h2>
        </div>
        <form action="functions/cadastrar_sala.php" method="POST">
            <h2>Cadastrar Salas:</h2>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="bloco">Bloco:</label>
                    <input type="text" class="form-control" id="bloco" name="bloco" placeholder="Bloco C">
                </div>
                <div class="form-group col-md-4">
                    <label for="andar">Andar:</label>
                    <input type="text" class="form-control" id="andar" name="andar" placeholder="1º Andar">
                </div>
                <div class="form-group col-md-4">
                    <label for="numero">Número:</label>
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="11C">
                </div>
                <div class="form-group col-md-4">
                    <label for="capacidade">Capacidade:</label>
                    <input type="number" class="form-control" id="capacidade" name="capacidade">
                </div>
                <div class="form-group col-md-8">
                    <label for="descr">Descrição:</label>
                    <input type="text" class="form-control" id="descr" name="descr" placeholder="Laboratório de Informática">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <h3>Disponível:</h3>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" checked name="dom" id="dom" value="dom">
                        <label class="form-check-label" for="dom">Domingo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" checked name="seg" id="seg" value="seg">
                        <label class="form-check-label" for="seg">Segunda-feira</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" checked name="ter" id="ter" value="ter">
                        <label class="form-check-label" for="ter">Terça-feira</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" checked name="qua" id="qua" value="qua">
                        <label class="form-check-label" for="qua">Quarta-feira</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" checked name="qui" id="qui" value="qui">
                        <label class="form-check-label" for="qui">Quinta-feira</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" checked name="sex" id="sex" value="sex">
                        <label class="form-check-label" for="sex">Sexta-feira</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" checked name="sab" id="sab" value="sab">
                        <label class="form-check-label" for="sab">Sábado</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
        <hr>
        <div class="salas">
            <table class="table table-striped text-center border">
                <thead>
                    <tr><th>Bloco</th><th>Andar</th><th>Número</th><th>Descrição</th><th>Capacidade</th><th>Sábado</th><th>Segunda</th><th>Terça</th><th>Quarta</th><th>Quinta</th><th>Sexta</th><th>Domingo</th><th>Ativo</th><th>Alterar</th></tr>
                </thead>
            <?php
                consultaSalas();
            ?>
            </table>
        </div>
    </main>

    <?php
        include ('../../footer.php');	
    ?>
</body>
</html>
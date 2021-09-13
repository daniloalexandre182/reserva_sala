<?php

include ('etc/conexao.php');

$sala = filter_input(INPUT_POST, 'salaid', FILTER_SANITIZE_STRING);
$data = (filter_input(INPUT_POST, 'datasql', FILTER_SANITIZE_STRING));
$solicitante = filter_input(INPUT_POST, 'solicitante', FILTER_SANITIZE_STRING);
$turma = filter_input(INPUT_POST, 'turma', FILTER_SANITIZE_STRING);


function reservada($sala, $data, $solicitante, $turma)
{
    $sql = "SELECT res_solicitante
    from tb_reserva
    where
    res_dtreserva = '$data'
    and res_salid = $sala
    and res_ativo = 1";
    $PDO = db_connect_rs();
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    $ocupacao = $stmt->fetchColumn();
    if($ocupacao != "")
        return "Erro, sala já reservada!";
    else
    {
        $ok = cadastrar($sala, $data, $solicitante, $turma);
        return $ok;
    }
        
}


function cadastrar($sala, $data, $solicitante, $turma)
{
    $sql = "INSERT INTO tb_reserva (res_dtreserva, res_solicitante, res_turma, res_salid, res_ativo)
    VALUES ('$data', '$solicitante', '$turma', $sala, 1);";
    $PDO = db_connect_rs();
    $stmt = $PDO->prepare($sql);
    $stmt->execute();
    return "Sala reservada com sucesso!";
}



$mensagem = reservada($sala, $data, $solicitante, $turma);
echo "<script>alert('$mensagem');</script>";
echo "<script>javascript:window.location.href='index.php';</script>";
exit;

?>
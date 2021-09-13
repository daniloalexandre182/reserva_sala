<?php

include ('../../etc/conexao.php');

$bloco = filter_input(INPUT_POST, 'bloco', FILTER_SANITIZE_STRING);
$andar = filter_input(INPUT_POST, 'andar', FILTER_SANITIZE_STRING);
$numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING);
$descr = filter_input(INPUT_POST, 'descr', FILTER_SANITIZE_STRING);
$capacidade = filter_input(INPUT_POST, 'capacidade', FILTER_SANITIZE_STRING);
if(isset($_POST['dom']))
    $dom = 1;
else
    $dom = 0;
if(isset($_POST['seg']))
    $seg = 1;
else
    $seg = 0;
if(isset($_POST['ter']))
    $ter = 1;
else
    $ter = 0;
if(isset($_POST['qua']))
    $qua = 1;
else
    $qua = 0;
    if(isset($_POST['qui']))
    $qui = 1;
else
    $qui = 0;
    if(isset($_POST['sex']))
    $sex = 1;
else
    $sex = 0;
if(isset($_POST['sab']))
    $sab = 1;
else
    $sab = 0;


  $sql = "INSERT INTO tb_sala (sal_bloco, sal_andar, sal_numero, sal_descr, sal_capacidade, sal_domingo, sal_segunda, sal_terca, sal_quarta, sal_quinta, sal_sexta, sal_sabado, sal_ativo)
  VALUES ('$bloco', '$andar', '$numero', '$descr', $capacidade, $dom, $seg, $ter, $qua, $qui, $sex, $sab, 1);";
  $PDO = db_connect_rs();
  $stmt = $PDO->prepare($sql);
  $stmt->execute();
  echo "Gravado com sucesso!";


?>
<?php

include('login/config.php');
include('login/verifica_login.php');
include('login/redirect.php');

require 'database.php';

//$inicio = $_POST['inicio'];
$start = new DateTime('2015-03-20 08:20:00');

//$fim = $_POST['fim'];
$end = new DateTime('2015-03-20 08:25:00');
//$total = null;
// $total = calculo da diferença para salvar no banco

//CALCULAR O TOTAL CALL PARA ARMAZENAR
        date_default_timezone_set('America/Sao_Paulo');
        
        
//        $inicio = DateTime::createFromFormat('H:i:s', $start);
//        $fim = DateTime::createFromFormat('H:i:s', $end);
        $total = $start->diff($end);
        $totalstr = (string)$total->format('%H:%I:%S');     
        

//        print $total->format('%H:%I:%S');

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT INTO testahora (total) values(?)";
$q = $pdo->prepare($sql);            
$q->execute(array($totalstr));
        
?>

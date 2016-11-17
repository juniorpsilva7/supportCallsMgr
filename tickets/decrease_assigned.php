<?php

include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');

// Conectar no banco e fazer um select onde seja igual a data corrente
// Ver se já tem a data atual
// Se já tiver atualizá-a
//Se não tiver, cria e seta como quantidade 1

require '../database.php';

$datacorrente = date('Y-m-d');
$pdoconn = Database::connect();
$prepara = $pdoconn->prepare('SELECT * FROM tickets WHERE data = ? AND user_id = ? LIMIT 1');
$parametros = array( $datacorrente, $_SESSION['user_id'] );
$prepara->execute( $parametros );
$row = $prepara->fetch();
if (empty($row) || $row['assigned']==0 ) {
    echo '<script language="javascript">';
    echo 'alert("Valor igual a Zero ou \n\nNenhum registro encontrado na data de hoje para diminuir!");';
    echo 'window.location.href = "http://localhost:8080/supp1.1/tickets";';
    echo '</script>';
    Database::disconnect();
    
} else{
    $novo = $row['assigned'] - 1;
    $prepara = $pdoconn->prepare('UPDATE tickets set assigned = ? WHERE id = ?');
    $parametros2 = array( $novo, $row['id'] );
    $prepara->execute( $parametros2 );
//    echo '<td><b>DATA '. $row['data'] . '</b></td>: Casos Abertos aumentado em 1!';
//    echo '<br/><br/><b><a class="btn" href="../tickets/index.php">Back</a></b>';
    header("Location: ../tickets/index.php");
    
    Database::disconnect();
}

?>



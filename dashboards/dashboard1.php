<?php
// Inclui o arquivo de configuração
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');

$datacorrente = date('Y-m-d');
//$datacorrente = date('2015-03-23');

//Usuários que aparecerão no dashboard
$users_dash = array(2,4,5);

include '../database.php';



//FUNÇÃO QUE RETORNA O NOME DO USUÁRIO DO ARRAY
function getUser($nrousuario){
    $pdo1 = Database::connect();
    $sql1 = $pdo1->prepare('SELECT user_name FROM `usuarios` WHERE user_id = ?');
    $parametros = array( $nrousuario );
    $sql1->execute( $parametros );
    $data = $sql1->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    echo '<td>'.$data['user_name'].'</td>';
}

//FUNÇÃO QUE RETORNA A QUANTIDADE DE LIGAÇÕES NO DIA
function getCalls($data, $nrousuario){
    $pdo2 = Database::connect();                  
    $sql2 = $pdo2->prepare("SELECT count(*) FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall = ? and calls.user_id = ? ");
    $parametros = array( $data, $nrousuario );
    $sql2->execute( $parametros );
    $qtdade = $sql2->fetchColumn();
    Database::disconnect();
    echo '<td>'.$qtdade.'</td>';
}

//FUNÇÃO QUE RETORNA A QUANTIDADE DE LIGAÇÕES NO DIA
function totalTime($data, $nrousuario){
//    SELECT  
//  SEC_TO_TIME( SUM( TIME_TO_SEC( `nome da coluna` ) ) ) AS total_time  
//FROM nomedatabela;
    $pdo3 = Database::connect();
    $sql3 = $pdo3->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`totalcall`))) AS total_time FROM calls where datecall= ? and user_id = ?');
    $parametros = array( $data, $nrousuario );
    $sql3->execute( $parametros );
    $qtdade = $sql3->fetchColumn();
    Database::disconnect();
    echo '<td><b>'.$qtdade.'</b></td>';    
}

//TOTAL DE DISPATCHER
function totDisp($data, $nrousuario){
    $pdo4 = Database::connect();
    $sql4 = $pdo4->prepare("SELECT count(*) FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall = ? and calls.user_id = ? and calls.typecall = 'D'");
    $parametros = array( $data, $nrousuario );
    $sql4->execute( $parametros );
    $qtdade = $sql4->fetchColumn();
    Database::disconnect();
    echo '<td>'.$qtdade.'</td>';
}

//TOTAL DE PRINTER
function totPrinter($data, $nrousuario){
    $pdo5 = Database::connect();
    $sql5 = $pdo5->prepare("SELECT count(*) FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall = ? and calls.user_id = ? and calls.typecall = 'P'");
    $parametros = array( $data, $nrousuario );
    $sql5->execute( $parametros );
    $qtdade = $sql5->fetchColumn();
    Database::disconnect();
    echo '<td>'.$qtdade.'</td>';
}

//TOTAL DE SCANNER
function totScanner($data, $nrousuario){
    $pdo6 = Database::connect();
    $sql6 = $pdo6->prepare("SELECT count(*) FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall = ? and calls.user_id = ? and calls.typecall = 'S'");
    $parametros = array( $data, $nrousuario );
    $sql6->execute( $parametros );
    $qtdade = $sql6->fetchColumn();
    Database::disconnect();
    echo '<td>'.$qtdade.'</td>';
}

//TOTAL DE COMPUTER
function totComputer($data, $nrousuario){
    $pdo7 = Database::connect();
    $sql7 = $pdo7->prepare("SELECT count(*) FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall = ? and calls.user_id = ? and calls.typecall = 'C'");
    $parametros = array( $data, $nrousuario );
    $sql7->execute( $parametros );
    $qtdade = $sql7->fetchColumn();
    Database::disconnect();
    echo '<td>'.$qtdade.'</td>';
}

//TOTAL DE OPENED
function totOpen($data, $nrousuario){
    $pdo8 = Database::connect();
    $sql8 = $pdo8->prepare("SELECT opened FROM tickets WHERE data = ? and user_id = ?");
    $parametros = array( $data, $nrousuario );
    $sql8->execute( $parametros );
    $data = $sql8->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    if (empty($data['opened'])){echo '<td><b>-</b></td>';}
    else{echo '<td><b>'.$data['opened'].'</b></td>';}
}

//TOTAL DE ASSIGNED
function totAssigned($data, $nrousuario){
    $pdo9 = Database::connect();
    $sql9 = $pdo9->prepare("SELECT assigned FROM tickets WHERE data = ? and user_id = ?");
    $parametros = array( $data, $nrousuario );
    $sql9->execute( $parametros );
    $data = $sql9->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    if (empty($data['assigned'])){echo '<td><b>-</b></td>';}
    else{echo '<td><b>'.$data['assigned'].'</b></td>';}
}

//TOTAL DE CLOSED
function totClosed($data, $nrousuario){
    $pdo10 = Database::connect();
    $sql10 = $pdo10->prepare("SELECT closed FROM tickets WHERE data = ? and user_id = ?");
    $parametros = array( $data, $nrousuario );
    $sql10->execute( $parametros );
    $data = $sql10->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    if (empty($data['closed'])){echo '<td><b>-</b></td>';}
    else{echo '<td><b>'.$data['closed'].'</b></td>';}
}

?>
<style>
.center-table
{
  margin: 0 auto !important;
  float: none !important;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="refresh" content="30" > 
    
</head>

<?php include ('../layout/header.php'); ?>
<blockquote></blockquote>
<br/>

    <body>
        <div class="container">
            <div class="row">
            <h4>Dashboard 1</h4>
            <h1><?php echo date('d-m-Y') ?></h1>
            </div>
        </div>
        
        <div class="container">
        <div class="row">
            <br/>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                      <th>User</th>
                      <th bgcolor="#F4A460">Calls</th>  
                      <th bgcolor="#F4A460">Total Time</th>
                      <th bgcolor="#87CEFA">Opened</th>
                      <th bgcolor="#87CEFA">Assigned</th>
                      <th bgcolor="#87CEFA">Closed</th>
                      <th bgcolor="#9ACD32">Dispatcher</th>
                      <th bgcolor="#9ACD32">Printer</th>
                      <th bgcolor="#9ACD32">Scanner</th>
                      <th bgcolor="#9ACD32">Computer</th>
                    </tr>
                  </thead>
                  
                  <tbody>                  
                     
                    <?php
                    
                    foreach ($users_dash as $i => $value) {
                        echo '<tr>';                        
                            getUser($value);
                            getCalls($datacorrente, $value);
                            totalTime($datacorrente, $value);
                            totOpen($datacorrente, $value);
                            totAssigned($datacorrente, $value);
                            totClosed($datacorrente, $value);
                            totDisp($datacorrente, $value);
                            totPrinter($datacorrente, $value);
                            totScanner($datacorrente, $value);
                            totComputer($datacorrente, $value);
                        echo '</tr>';
                    }
                    
                    ?>   
                      
                  </tbody>
                
            </table>
        </div>
        </div>

    <?php include ('../layout/footer.php'); ?>
    </body>
</html>
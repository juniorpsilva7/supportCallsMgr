<?php
// Inclui o arquivo de configuração
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');

//$datacorrente = date('Y-m-d');

if (isset($_POST["dateini"])){
    $dateIni = $_POST['dateini'];
    $dateEnd = $_POST['dateend'];
}else{
    $dateIni = NULL;
    $dateEnd = NULL;
}



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
function getCalls($di, $de, $nrousuario){
    $pdo2 = Database::connect();                  
    $sql2 = $pdo2->prepare("SELECT count(*) FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall >= ? and calls.datecall <= ? and calls.user_id = ?; ");
    $parametros = array( $di, $de, $nrousuario );
    $sql2->execute( $parametros );
    $qtdade = $sql2->fetchColumn();
    Database::disconnect();
    echo '<td>'.$qtdade.'</td>';
}

//FUNÇÃO QUE RETORNA O TEMPO TOTAL DE LIGAÇÕES NO DIA
function totalTime($di, $de, $nrousuario){
//    SELECT  
//  SEC_TO_TIME( SUM( TIME_TO_SEC( `nome da coluna` ) ) ) AS total_time  
//FROM nomedatabela;
    $pdo3 = Database::connect();
    $sql3 = $pdo3->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`totalcall`))) AS total_time FROM calls where datecall >= ? and datecall <= ? and user_id = ?');
    $parametros = array( $di, $de, $nrousuario );
    $sql3->execute( $parametros );
    $qtdade = $sql3->fetchColumn();
    Database::disconnect();
    echo '<td><b>'.$qtdade.'</b></td>';    
}

//TOTAL DE DISPATCHER
function totDisp($di, $de, $nrousuario){
    $pdo4 = Database::connect();
    $sql4 = $pdo4->prepare("SELECT count(*) FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall >= ? and calls.datecall <= ? and calls.user_id = ? and calls.typecall = 'D'");
    $parametros = array( $di, $de, $nrousuario );
    $sql4->execute( $parametros );
    $qtdade = $sql4->fetchColumn();
    Database::disconnect();
    echo '<td>'.$qtdade.'</td>';
}

//TOTAL DE PRINTER
function totPrinter($di, $de, $nrousuario){
    $pdo5 = Database::connect();
    $sql5 = $pdo5->prepare("SELECT count(*) FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall >= ? and calls.datecall <= ? and calls.user_id = ? and calls.typecall = 'P'");
    $parametros = array( $di, $de, $nrousuario );
    $sql5->execute( $parametros );
    $qtdade = $sql5->fetchColumn();
    Database::disconnect();
    echo '<td>'.$qtdade.'</td>';
}

//TOTAL DE SCANNER
function totScanner($di, $de, $nrousuario){
    $pdo6 = Database::connect();
    $sql6 = $pdo6->prepare("SELECT count(*) FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall >= ? and calls.datecall <= ? and calls.user_id = ? and calls.typecall = 'S'");
    $parametros = array( $di, $de, $nrousuario );
    $sql6->execute( $parametros );
    $qtdade = $sql6->fetchColumn();
    Database::disconnect();
    echo '<td>'.$qtdade.'</td>';
}

//TOTAL DE COMPUTER
function totComputer($di, $de, $nrousuario){
    $pdo7 = Database::connect();
    $sql7 = $pdo7->prepare("SELECT count(*) FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall >= ? and calls.datecall <= ? and calls.user_id = ? and calls.typecall = 'C'");
    $parametros = array( $di, $de, $nrousuario );
    $sql7->execute( $parametros );
    $qtdade = $sql7->fetchColumn();
    Database::disconnect();
    echo '<td>'.$qtdade.'</td>';
}

//TOTAL DE OPENED
function totOpen($di, $de, $nrousuario){
    $pdo8 = Database::connect();
    $sql8 = $pdo8->prepare("SELECT SUM(opened) FROM tickets WHERE data >= ? and data <= ? and user_id = ?");
    $parametros = array( $di, $de, $nrousuario );
    $sql8->execute( $parametros );
    $data = $sql8->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    if (empty($data['SUM(opened)'])){echo '<td><b>-</b></td>';}
    else{echo '<td><b>'.$data['SUM(opened)'].'</b></td>';}
}

//TOTAL DE ASSIGNED
function totAssigned($di, $de, $nrousuario){
    $pdo9 = Database::connect();
    $sql9 = $pdo9->prepare("SELECT SUM(assigned) FROM tickets WHERE data >= ? and data <= ? and user_id = ?");
    $parametros = array( $di, $de, $nrousuario );
    $sql9->execute( $parametros );
    $data = $sql9->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    if (empty($data['SUM(assigned)'])){echo '<td><b>-</b></td>';}
    else{echo '<td><b>'.$data['SUM(assigned)'].'</b></td>';}
}

//TOTAL DE CLOSED
function totClosed($di, $de, $nrousuario){
    $pdo10 = Database::connect();
    $sql10 = $pdo10->prepare("SELECT SUM(closed) FROM tickets WHERE data >= ? and data <= ? and user_id = ?");
    $parametros = array( $di, $de, $nrousuario );
    $sql10->execute( $parametros );
    $data = $sql10->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    if (empty($data['SUM(closed)'])){echo '<td><b>-</b></td>';}
    else{echo '<td><b>'.$data['SUM(closed)'].'</b></td>';}
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
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   
    
</head>

<?php include ('../layout/header.php'); ?>
<blockquote></blockquote>
<br/>

    <body>
        <div class="container">
            <div class="row">
            <h3>Dashboard 2</h3>
            </div>
        
        <div class="row">
            
            <form class="form span15 offset1" action="dashboard2.php" method="post">
                
                <!--DATA DE INICIO DA PESQUISA-->                
                <div class="control-group form-actions">
                    <label class="control-label"><b>Start</b></label>
                        <div class="controls">
                            <input name="dateini" type="text" id="datepicker"/>
                            <!--<input name="dateini" type="date" placeholder="dd/MM/yyyy"/>-->
                        </div>
                <br/>
                
                <!--DATA DE FIM DA PESQUISA-->                
                    <label class="control-label"><b>End</b></label>
                        <div class="controls">
                            <input name="dateend" type="text" id="datepicker2"/>
                            <!--<input name="dateend" type="date" placeholder="dd/MM/yyyy"/>-->
                        </div>
                    <br/>
                    
                    <div class="controls">
                    <button type="submit">Submit</button>
                    </div>
                </div>
                
            </form>
            
            <br/><br/>
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
                            getCalls($dateIni, $dateEnd, $value);
                            totalTime($dateIni, $dateEnd, $value);
                            totOpen($dateIni, $dateEnd, $value);
                            totAssigned($dateIni, $dateEnd, $value);
                            totClosed($dateIni, $dateEnd, $value);
                            totDisp($dateIni, $dateEnd, $value);
                            totPrinter($dateIni, $dateEnd, $value);
                            totScanner($dateIni, $dateEnd, $value);
                            totComputer($dateIni, $dateEnd, $value);
                        echo '</tr>';
                    }
                    
                    ?>   
                      
                  </tbody>
                
            </table>
        
        </div>
        </div>

    <?php include ('../layout/footer.php'); ?>
    </body>
        <!--COMPONENTES DO DATEPICKER-->
<!--    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <script>
    $(function() {
    $( "#datepicker" ).datepicker({
        dateFormat: "yy-mm-dd"}
        );
    $( "#datepicker2" ).datepicker({
        dateFormat: "yy-mm-dd"}
        );
    });
    </script>
    <!-- FIM COMPONENTES DO DATEPICKER-->
</html>
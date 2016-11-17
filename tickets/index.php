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

//function increase_open(){
//    require '../database.php';
//
//    $datacorrente = date('Y-m-d');
//    $pdoconn = Database::connect();
//    $prepara = $pdoconn->prepare('SELECT * FROM tickets WHERE data = ? AND user_id = ? LIMIT 1');
//    $parametros = array( $datacorrente, $_SESSION['user_id'] );
//    $prepara->execute( $parametros );
//    $row = $prepara->fetch();
//    if (empty($row)) {
//        $prepara = $pdoconn->prepare('INSERT INTO tickets (data, user_id, opened, assigned, closed) values (?, ?, ?, ?, ?)');
//        $parametros2 = array( $datacorrente, $_SESSION['user_id'], 1, 0, 0 );
//        $prepara->execute( $parametros2 );
//        Database::disconnect();
//    } else{
//        $novo = $row['opened'] + 1;
//        $prepara = $pdoconn->prepare('UPDATE tickets set opened = ? WHERE id = ?');
//        $parametros2 = array( $novo, $row['id'] );
//        $prepara->execute( $parametros2 );
//        Database::disconnect();
//    }
//}
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
    <!--<script src="../js/bootstrap.min.js"></script>-->

</head>

<?php include ('../layout/header.php'); ?>
<blockquote></blockquote>

<body>
   <div class="container">
       <br/><br/>
<!--        <div class="row">
                <h3>Tickets</h3>
        </div>-->
       
       <div class="row">
<!--            <p>
                    <a href="../index.php" class="btn btn-success">Home</a>
                    
            </p>-->
            
<!--            <p>
                <button class="btn btn-success" onclick="increase_open();">+1 Open</button>
                <button class="btn btn-success" onclick="decrease_open();">-1 Open</button>
                <a class="btn" href="../tickets/increase_opened.php">+1 Opened</a>
                <a class="btn" href="../tickets/decrease_opened.php">-1 Opened</a>
                <br/><br/>
                <a class="btn" href="../tickets/increase_assigned.php">+1 Assigned</a>
                <a class="btn" href="../tickets/decrease_assigned.php">-1 Assigned</a>
                <br/><br/>
                <a class="btn" href="../tickets/increase_closed.php">+1 Closed</a>
                <a class="btn" href="../tickets/decrease_closed.php">-1 Closed</a>
            </p>-->
           
           <p>
                <a href="list.php" class="btn btn-small btn-warning">List ALL</a>
           </p>
           
           <br/>
           <table class="table table-striped table-bordered">
               <thead>
                    <tr>
                      <th>Date</th>
                      <th>User</th>  
                      <th>Opened</th>
                      <th>Assigned</th>
                      <th>Closed</th>
                      <!--<th></th>-->
                    </tr>
                  </thead>
               
                  <tbody>
                      
                   <?php
                   include '../database.php';
                   $pdo_index = Database::connect();
                   $prepara = $pdo_index->prepare('SELECT * FROM tickets WHERE user_id = ? AND data = ?');
                   $parametros = array( $_SESSION['user_id'], $datacorrente );
                   $prepara->execute( $parametros );
                   while ( $row = $prepara->fetch()) {
                            echo '<tr>';
                                echo '<td>'. $row['data'] . '</td>';
                                echo '<td>'. $_SESSION['nome_usuario'] . '</td>';
                                echo '<td>'. $row['opened'] . '</td>';
                                echo '<td>'. $row['assigned'] . '</td>';
                                echo '<td>'. $row['closed'] . '</td>';
//                                echo '<td width=250>';
//                                echo '<a class="btn" href="read.php?id='.$row['id'].'">Read</a>';
//                                echo ' ';
//                                echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
//                                echo ' ';
//                                echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
//                                echo '</td>';
                                echo '</tr>';
                   }
                   Database::disconnect();
                  ?>   
                      
                  </tbody>
           </table>           
           
           <br/>
           
           <div class="span6 center-table">
           <table class="table table-bordered table-condensed">
                <thead bgcolor="#FFFFE0">
                    <tr><th>Opened</th><th>Assigned</th><th>Closed</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <a class="btn" href="../tickets/increase_opened.php">+1</a>
                            <a class="btn" href="../tickets/decrease_opened.php">-1</a>
                        </td>
                        <td>
                            <a class="btn" href="../tickets/increase_assigned.php">+1</a>
                            <a class="btn" href="../tickets/decrease_assigned.php">-1</a>
                        </td>
                        <td>
                            <a class="btn" href="../tickets/increase_closed.php">+1</a>
                            <a class="btn" href="../tickets/decrease_closed.php">-1</a>
                        </td>
                    </tr>
                </tbody>
            </table>
           </div>
           
       </div>
       
       
<!--        <div class="form-actions">
            <a class="btn" href="../index.php">Back</a>
        </div>-->
   </div>
</body>
<?php include ('../layout/footer.php'); ?>


<!--<script>
function increase_open(){
      $.ajax({
           url: '../tickets/increase_opened.php',
      });
 }
 function decrease_open(){
      $.ajax({
           url: '../tickets/decrease_opened.php',
      });
 }
 
</script>-->
</html>
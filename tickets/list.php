<?php
// Inclui o arquivo de configuração
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');
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
       
       <div class="row">           
           
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
                   $prepara = $pdo_index->prepare('SELECT * FROM tickets WHERE user_id = ?');
                   $parametros = array( $_SESSION['user_id'] );
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
           
<!--           <div class="span6 center-table">
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
           </div>-->
           
       </div>
       
       
        <div class="form-actions">
            <a class="btn" href="index.php">Back</a>
        </div>
   </div>
</body>
<?php include ('../layout/footer.php'); ?>

</html>
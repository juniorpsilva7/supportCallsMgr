<?php
// Inclui o arquivo de configuração
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');

//PEGA DATA ATUAL
$datacorrente = date('Y-m-d');

?>
<style>
#actionbtn {
margin-top:5%;
/*margin-bottom:5%;*/
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <!--<script src="js/bootstrap.min.js"></script>-->
    
</head>

<?php include ('../layout/header.php'); ?>
<blockquote></blockquote>

<body>
    <div class="container">
        <br/><br/>
        <!-- ============== RELÓGIO ==============-->

        <!-- ============== FIM RELÓGIO ==============-->
            
<!--            <div class="row">
                <h3>Call System</h3>
            </div>-->
            <div class="row">
                <p>
                    <a href="../calls/list.php" class="btn btn-small btn-warning">List ALL</a>
                </p>
                
                <p>
                    <a href="../calls/create.php" class="btn btn-info btn-large btn-block"><b>+ New Call</b></a>
                </p>
                <br/>
                <!--<table class="table table-striped table-bordered">-->
                <table class="table table-condensed">
                  <thead bgcolor="#D3D3D3">
                    <tr>
                      <!--<th>Date</th>-->
                      <!--<th>User</th>-->
                      <!--<th>Later</th>-->
                      <th>Start</th>
                      <th>From</th>
                       <th>Type</th>
                      <th>Contact</th>
                      <th>Company</th>
                      <!--<th>CNPJ</th>-->
                      <th width="30%">Device Info</th>
                      <th width="50%">Notes</th>
                      <th>End</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                   <?php
                   include '../database.php';
                   $pdo_index = Database::connect();
                   $prepara = $pdo_index->prepare('SELECT * FROM calls WHERE user_id = ? AND datecall = ?');
                   $parametros = array( $_SESSION['user_id'], $datacorrente );
                   $prepara->execute( $parametros );
                   while ( $row = $prepara->fetch()) {
                       if ($row['later']==0){echo '<tr>';
                       }else{echo "<tr bgcolor='#FFFFA3' >";}
//                                echo '<td>'. $row['date'] . '</td>';
//                                echo '<td>'. $row['user_id'] . '</td>';
//                                echo '<td>'. $row['later'] . '</td>';
                                echo '<td>'. $row['startcall'] . '</td>';
                                echo '<td>'. $row['tel_ava'] . '</td>';
                                echo '<td>'. $row['typecall'] . '</td>';
                                echo '<td>'. $row['contacts'] . '</td>';
                                echo '<td>'. $row['company'] . '</td>';
//                                echo '<td>'. $row['cnpj'] . '</td>';
                                echo '<td>'. $row['deviceinfo'] . '</td>';
                                echo '<td>'. $row['notes'] . '</td>';
                                echo '<td>'. $row['endcall'] . '</td>';
                                echo '<td width=250>';
//                                echo '<a class="btn" href="calls/read.php?id='.$row['id'].'">Read</a>';
//                                echo ' ';
                                echo '<a id="actionbtn" class="btn btn-success" href="../calls/update.php?id='.$row['id'].'">Update</a>';
                                echo ' ';
                                echo '<a id="actionbtn" class="btn btn-danger" href="../calls/delete.php?id='.$row['id'].'">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                   }
                   Database::disconnect();
                  ?>   
                      
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
    <?php include ('../layout/footer.php'); ?>
  </body>
</html>
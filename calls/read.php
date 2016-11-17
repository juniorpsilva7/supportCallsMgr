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

<?php
    require '../database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: index.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM calls where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <!--<meta charset="utf-8">-->
    <!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />--> 
    <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Read a Call</h3>
                    </div>
                     
                    <div class="form-horizontal" >
                        
                      <div class="control-group">
                        <label class="control-label">Start</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['startcall'];?>
                            </label>
                        </div>
                      </div>
                        
                      <div class="control-group">
                        <label class="control-label">From</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php 
                                if ($data['tel_ava']=='T'){
                                    echo "Phone";}
                                else{
                                    echo "Avaya";}?>
                            </label>
                        </div>
                      </div>
                       
                      
                      <div class="control-group">
                        <label class="control-label">Type</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php 
                                    if ($data['typecall']=='D'){
                                        echo "Dispatcher";}
                                    elseif ($data['typecall']=='P'){
                                        echo "Printer";}
                                    elseif ($data['typecall']=='S'){
                                        echo "Scanner";}
                                    else {
                                        echo "Computer";}
                                    ?>
                                
                            </label>
                        </div>
                      </div>
                        
                      <div class="control-group">
                        <label class="control-label">Contact Info</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['contacts'];?>
                            </label>
                        </div>
                      </div>
                        
                      <div class="control-group">
                        <label class="control-label">Company</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['company'];?>
                            </label>
                        </div>
                      </div>
                        
                      <div class="control-group">
                        <label class="control-label">Device Info</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['deviceinfo'];?>
                            </label>
                        </div>
                      </div>
                      
                      <div class="control-group">
                        <label class="control-label">Annotations</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['notes'];?>
                            </label>
                        </div>
                      </div>
                      
                      <div class="control-group">
                        <label class="control-label">End</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['endcall'];?>
                            </label>
                        </div>
                      </div>
                        
                        
                        <div class="form-actions">
                          <a class="btn" href="../index.php">Back</a>
                       </div>
                     
                      
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
<?php
// Inclui o arquivo de configuração
include('../login/config.php');

// Inclui o arquivo de verificação de login
include('../login/verifica_login.php');

// Se não for permitido acesso nenhum ao arquivo
// Inclua o trecho abaixo, ele redireciona o usuário para 
// o formulário de login
include('../login/redirect.php');

    require '../database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: ../index.php");
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $contactsError = null;
        $companyError = null;
        $cnpjError = null;
        $deviceinfoError = null;
        $notesError = null;
        $endcallError = null;
         
        // keep track post values
        $later = $_POST['later'];
        $startcall = $_POST['startcall'];
        $tel_ava = $_POST['tel_ava'];
        $typecall = $_POST['typecall'];
        $contacts = $_POST['contacts'];
        $company = $_POST['company'];
        $cnpj = $_POST['cnpj'];
        $deviceinfo = $_POST['deviceinfo'];
        $notes = $_POST['notes'];
        $endcall = $_POST['endcall'];
        
        //CALCULAR O TOTAL CALL PARA ARMAZENAR
        if(!empty($endcall)){
        $inicio = DateTime::createFromFormat('H:i:s', $startcall);
        $fim = DateTime::createFromFormat('H:i:s', $endcall);
        $intervalo = $inicio->diff($fim);
        $intervalostr = (string)$intervalo->format('%H:%I:%S');
        } 
         
        // validate input
        $valid = true;
        if (empty($contacts)) {
            $contactsError = 'Please enter some contact info';
            $valid = false;
        }
//        if (empty($company)) {
//            $companyError = 'Please enter a company';
//            $valid = false;
//        }
//        if (empty($cnpj)) {
//            $cnpjError = 'Please enter a cnpj';
//            $valid = false;
//        }
//        if (empty($deviceinfo)) {
//            $deviceinfoError = 'Please enter some device info';
//            $valid = false;
//        }
//        if (empty($notes)) {
//            $notesError = 'Please enter some notes';
//            $valid = false;
//        }
        if (empty($endcall)) {
            $endcallError = 'Please enter a end time';
            $valid = false;
        } 
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE calls  set later = ?, startcall = ?, tel_ava = ?, typecall = ?, contacts = ?, company = ?, cnpj = ?, deviceinfo = ?, notes = ?, endcall = ?, totalcall = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($later, $startcall,$tel_ava,$typecall,$contacts,$company,$cnpj,$deviceinfo,$notes,$endcall,$intervalostr,$id));
            Database::disconnect();
            header("Location: ../index.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM calls where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $later = $data['later'];
        $startcall = $data['startcall'];
        $tel_ava = $data['tel_ava'];
        $typecall = $data['typecall'];
        $contacts = $data['contacts'];
        $company = $data['company'];
        $cnpj = $data['cnpj'];
        $deviceinfo = $data['deviceinfo'];
        $notes = $data['notes'];
        $endcall = $data['endcall'];
        Database::disconnect();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--<meta charset="utf-8">-->
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.min.js"></script>
</head>
 

<?php include ('../layout/header.php'); ?>
<blockquote></blockquote>
<br/>

<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>EDIT</h3>
                    </div>
             
                    <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
                      
                       
                      <div class="control-group <?php echo !empty($startcallError)?'error':'';?>">
                        <label class="control-label">Start</label>
                        <div class="controls">
                            <input readonly="true" name="startcall" type="text"  placeholder="Start Call" value="<?php echo !empty($startcall)?$startcall:'';?>">
                            <?php if (!empty($startcallError)): ?>
                                <span class="help-inline"><?php echo $startcallError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                        
                      <div class="radio">
                        <div class="controls">
                            <label class="radio inline"><input name="tel_ava" type="radio" value="T" <?php if ($tel_ava == "T"){echo "checked";} ?> >Tel</label>
                            <label class="radio inline"><input name="tel_ava" type="radio" value="A" <?php if ($tel_ava == "A"){echo "checked";} ?> >Avaya</label>
                        </div>
                      </div>
                      
                    <br/>
                      
                    <div class="control-group">
                        <label class="control-label">Type</label>
                        <div class="controls">
                            <select name="typecall" class="selectpicker">
                                <option value="D" <?php if ($typecall == "D"){echo "selected";} ?> >Dispatcher</option>
                                <option value="P" <?php if ($typecall == "P"){echo "selected";} ?> >Printer</option>
                                <option value="S" <?php if ($typecall == "S"){echo "selected";} ?> >Scanner</option>
                                <option value="C" <?php if ($typecall == "C"){echo "selected";} ?> >Computer</option>
                            </select>
                        </div>
                      </div>
                        
                      <div class="control-group <?php echo !empty($contactsError)?'error':'';?>">
                        <label class="control-label">Contact</label>
                        <div class="controls">
                            <input name="contacts" type="text"  placeholder="Contacts Info" value="<?php echo !empty($contacts)?$contacts:'';?>">
                            <?php if (!empty($contactsError)): ?>
                                <span class="help-inline"><?php echo $contactsError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                    
                      <div class="control-group <?php echo !empty($companyError)?'error':'';?>">
                        <label class="control-label">Company</label>
                        <div class="controls">
                            <input name="company" type="text"  placeholder="Company" value="<?php echo !empty($company)?$company:'';?>">
                            <?php if (!empty($companyError)): ?>
                                <span class="help-inline"><?php echo $companyError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                    
                      <div class="control-group <?php echo !empty($cnpjError)?'error':'';?>">
                        <label class="control-label">CNPJ</label>
                        <div class="controls">
                            <input name="cnpj" type="text"  placeholder="CNPJ" value="<?php echo !empty($cnpj)?$cnpj:'';?>">
                            <?php if (!empty($cnpjError)): ?>
                                <span class="help-inline"><?php echo $cnpjError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                        
                      <div class="control-group <?php echo !empty($deviceinfoError)?'error':'';?>">
                        <label class="control-label">Device Info</label>
                        <div class="controls">
                            <textarea name="deviceinfo" rows="5" type="text"  placeholder="Device Info"><?php echo !empty($deviceinfo)?$deviceinfo:'';?></textarea>
                            <?php if (!empty($deviceinfoError)): ?>
                                <span class="help-inline"><?php echo $deviceinfoError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                    
                      <div class="control-group <?php echo !empty($notesError)?'error':'';?>">
                        <label class="control-label">Notes</label>
                        <div class="controls">
                            <textarea name="notes" rows="8" placeholder="Annotation" ><?php echo !empty($notes)?$notes:'';?></textarea>
                            <?php if (!empty($notesError)): ?>
                                <span class="help-inline"><?php echo $notesError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                    
                      <div class="control-group <?php echo !empty($endcallError)?'error':'';?>">
                        <label class="control-label">End</label>
                        <div class="controls">
                            <input readonly="true" name="endcall" type="text"  placeholder="End Call" value="<?php echo !empty($endcall)?$endcall:'';?>">
                            <?php if (!empty($endcallError)): ?>
                                <span class="help-inline"><?php echo $endcallError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                    
                      <div class="control-group">
                          <div class="controls">
                            <label class="checkbox">
                              <input type="hidden" value="0" name="later" />
                              <input name="later" type="checkbox" value="1" <?php if ($later == "1"){echo "checked";} ?> /><b>Open Later?</b></input
                            </label>
                          </div>
                      </div>
                    
                        
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="../index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
    <?php include ('../layout/footer.php'); ?>
  </body>
</html>
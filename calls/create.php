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
 
    if ( !empty($_POST)) {
        // keep track validation errors
//        $dateError = null;

        $contactsError = null;
        $companyError = null;
        $cnpjError = null;
        $deviceinfoError = null;
        $notesError = null;
        $endcallError = null;
         
        // keep track post values
//        $datecall = $_POST['datecall'];
//        $date_mysql = implode("-",array_reverse(explode("/", $_POST["date"]))); // converte data para mysql
        $idsessao = $_SESSION['user_id'];
        $startcall = $_POST['startcall'];
        $tel_ava = $_POST['tel_ava'];
        $typecall = $_POST['typecall'];
        $contacts = $_POST['contacts'];
        $company = $_POST['company'];
        $cnpj = $_POST['cnpj'];
        $deviceinfo = $_POST['deviceinfo'];
        $notes = $_POST['notes'];
        $endcall = $_POST['endcall'];
        $later = $_POST['later'];
        $opened = $_POST['opened'];
        $assigned = $_POST['assigned'];
        
        
        //CALCULAR O TOTAL CALL PARA ARMAZENAR
        if(!empty($endcall)){
        $inicio = DateTime::createFromFormat('H:i:s', $startcall);
        $fim = DateTime::createFromFormat('H:i:s', $endcall);
        $intervalo = $inicio->diff($fim);
        $intervalostr = (string)$intervalo->format('%H:%I:%S');
        }
         
        // validate input
        $valid = true;
        
//        if (empty($startcall)) {
//            $startcallError = 'Please enter a start time';
//            $valid = false;
//        }
//        if (empty($tel_ava)) {
//            $tel_avaError = 'Please enter where it is from';
//            $valid = false;
//        }
        
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
         
        // insert data
        $datacorrente = date('Y-m-d');
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO calls (user_id, datecall, later, startcall, tel_ava, typecall, contacts, company, cnpj, deviceinfo, notes, endcall, totalcall) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);            
            $q->execute(array($idsessao, $datacorrente, $later, $startcall, $tel_ava, $typecall, $contacts, $company, $cnpj, $deviceinfo, $notes, $endcall, $intervalostr));
            
            //Valida para inserção dentro da tabela tickets do banco
            if (!empty($opened) && !empty($assigned)){
                $prepara = $pdo->prepare('SELECT * FROM tickets WHERE data = ? AND user_id = ? LIMIT 1');
                $parametros = array( $datacorrente, $_SESSION['user_id'] );
                $prepara->execute( $parametros );
                $row = $prepara->fetch();
                if (empty($row)) {
                    $prepara = $pdo->prepare('INSERT INTO tickets (data, user_id, opened, assigned, closed) values (?, ?, ?, ?, ?)');
                    $parametros2 = array( $datacorrente, $_SESSION['user_id'], $opened, $assigned, 0 );
                    $prepara->execute( $parametros2 );
                    Database::disconnect();
                } else{
                    $novo = $row['opened'] + $opened;
                    $assumido = $row['assigned'] + $assigned;
                    $prepara = $pdo->prepare('UPDATE tickets set opened = ?, assigned = ? WHERE id = ?');
                    $parametros2 = array( $novo, $assumido, $row['id'] );
                    $prepara->execute( $parametros2 );
                    Database::disconnect();
                }

            
            }
            Database::disconnect();
            header("Location: ../index.php");
        }
        
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!--<meta charset="utf-8">-->
    <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
    <!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />--> 
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <!--<link rel="icon" type="image/png" href="../img/glyphicons-halflings.png" />-->
    
    
    
</head>
 
<?php include ('../layout/header.php'); ?>
<blockquote></blockquote>
<br/>

<body>
    <div class="container">
     
                <div class="span8 offset1">
                    <div class="row">
                        <h4>New Call</h4>
                    </div>
                    
                    
                    <!--INICIO DO FORMULARIO-->             
                    <form name="form1" class="form-horizontal" action="create.php" method="post">
                        
                       <!--CAMPO DO INICIO DA LIGACAO-->               
                       <div class="control-group <?php echo !empty($startcallError)?'error':'';?>">
                        <label class="control-label">Start</label>
                        <div class="controls">
                            <input name="startcall" size="16" type="text" value="<?php 
                                $tz_object = new DateTimeZone('Brazil/East');
                                //date_default_timezone_set('Brazil/East');
                                $db_datetime = new DateTime();
                                $db_datetime->setTimezone($tz_object);
                                echo $db_datetime->format('H:i:s');
                                ?>" readonly class="form_datetime">

                            <?php if (!empty($startcallError)): ?>
                                <span class="help-inline"><?php echo $startcallError;?></span>
                            <?php endif;?>
                        </div>
                      </div> 
                      
                      <!--CAMPO DE ONDE VEM A LIGACAO: TELEFONE OU AVAYA-->
                      <div class="radio">
                        <div class="controls">
                            <label class="radio inline"><input name="tel_ava" type="radio" value="T" checked>Tel</label>
                            <label class="radio inline"><input name="tel_ava" type="radio" value="A">Avaya</label>
                        </div>
                      </div>
                      
                    <br/>
                      
                      <!--CAMPO DO TIPO DE LIGACAO-->
                      <div class="control-group">
                          <label class="control-label">Type Call</label>
                          <div class="controls">
                              <select name="typecall" class="selectpicker">
                                <optgroup>  
                                    <option value="D">Dispatcher</option>
                                    <option value="P">Printer</option>
                                    <option value="S">Scanner</option>
                                    <option value="C">Computer</option>
                                </optgroup>
                                <optgroup>
                                    <option value="O">Outgoing Call</option>
                                </optgroup>
                              </select>
                          </div>
                      </div>
                        
                      <!--CAMPO INFORMACOES DE CONTATO-->
                      <div class="control-group <?php echo !empty($contactsError)?'error':'';?>">
                        <label class="control-label">Contact</label>
                        <div class="controls">
                            <input name="contacts" type="text"  placeholder="Contacts Info" value="<?php echo !empty($contacts)?$contacts:'';?>">
                            <?php if (!empty($contactsError)): ?>
                                <span class="help-inline"><?php echo $contactsError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                      <!--CAMPO INFORMACOES DA EMPRESA-->
                      <div class="control-group <?php echo !empty($companyError)?'error':'';?>">
                        <label class="control-label">Company</label>
                        <div class="controls">
                            <input name="company" type="text"  placeholder="Company" value="<?php echo !empty($company)?$company:'';?>">
                            <?php if (!empty($companyError)): ?>
                                <span class="help-inline"><?php echo $companyError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                      <!--CAMPO CNPJ-->
                      <div class="control-group <?php echo !empty($cnpjError)?'error':'';?>">
                        <label class="control-label">CNPJ</label>
                        <div class="controls">
                            <input name="cnpj" type="text"  placeholder="CNPJ" value="<?php echo !empty($cnpj)?$cnpj:'';?>">
                            <?php if (!empty($cnpjError)): ?>
                                <span class="help-inline"><?php echo $cnpjError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                      <!--CAMPO INFORMACOES DO EQUIPAMENTO-->
                      <div class="control-group <?php echo !empty($deviceinfoError)?'error':'';?>">
                        <label class="control-label">Device Info</label>
                        <div class="controls">
                            <textarea name="deviceinfo" rows="5" placeholder="Device information"><?php echo !empty($deviceinfo)?$deviceinfo:'';?></textarea>
                            <!--<input name="deviceinfo" type="text"  placeholder="Device information" value="<?php// echo !empty($deviceinfo)?$deviceinfo:'';?>">-->
                            <?php if (!empty($deviceinfoError)): ?>
                                <span class="help-inline"><?php echo $deviceinfoError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                      <!--CAMPO PARA ANOTACOES EM GERAL-->
                      <div class="control-group <?php echo !empty($notesError)?'error':'';?>">
                        <label class="control-label">Notes</label>
                        <div class="controls">
                            <textarea name="notes" rows="8" placeholder="Annotations"><?php echo !empty($notes)?$notes:'';?></textarea>
                            <!--<input name="notes" type="text"  placeholder="Notes" value="<?php// echo !empty($notes)?$notes:'';?>">-->
                            <?php if (!empty($notesError)): ?>
                                <span class="help-inline"><?php echo $notesError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                        
                      <!--CAMPO PARA FINAL DA LIGACAO-->
                      <script type="text/javascript">
                        function setaEndCall() {                                        
                                        d = new Date();
                                        //Pega data no formato yyyy-MM-dd hh:mm:ss
//                                        year = d.getFullYear();
//                                        month = ((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1);
//                                        day = (d.getDate() < 10 ? '0' : '') + d.getDate();
                                        hours = ('0'+d.getHours()).substr(-2);
                                        minutes = (d.getMinutes()<10?'0':'') + d.getMinutes();
                                        seconds = (d.getSeconds()<10?'0':'') + d.getSeconds();
                                        
                                        //salva tudo em uma string
                                        datetext = hours+':'+minutes+':'+seconds;
                                        document.getElementById("id_end_call").value = datetext;
                                }
                      </script>
                        
                      <div class="control-group <?php echo !empty($endcallError)?'error':'';?>">
                        <label class="control-label">End</label>
                        <div class="controls">
                            <!--<input name="endcall" type="datetime" value="<?php// echo !empty($endcall)?$endcall:'';?>">-->
                            <input id="id_end_call" type="text" name="endcall"/> &nbsp <button type="button" onclick=setaEndCall()>Stop</button>
                            <?php if (!empty($endcallError)): ?>
                                <span class="help-inline"><?php echo $endcallError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      
                      
                      <!--CAMPO PARA CHAMADOS ABERTOS E ASSUMIDOS-->
                      <div class="alert alert-success">
                            <label align="center"><strong>SF Cases from this Call</strong></label><br/>
                            
                            <div class="controls">
                            <label class="checkbox">
                              <input type="hidden" value="0" name="later" />
                              <input name="later" type="checkbox" value="1" /><b>Open Later?</b></input
                            </label>  
                            </div>
                            <br/>
                                                       
                            <div class="control-group">
                            <label class="control-label"><b>Opened</b></label>
                            <div class="controls">
                                <input type="number" name="opened" min="0" max="5" value="0" />
                            </div>
                            </div>

                            <div class="control-group">
                            <label class="control-label"><b>Assigned</b></label>
                            <div class="controls">
                                <input type="number" name="assigned" min="0" max="5" value="0" />
                            </div>
                            </div>
                      </div>
                      
                      
                      
                        
                        <!--   BOTÃO SUBMIT   -->
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="../index.php">Back</a>
                      </div>
                        
                    </form>
                </div>
                 
    </div> <!-- /container -->
    <?php include ('../layout/footer.php'); ?>
  </body>
  <script src="../js/bootstrap.min.js"></script>
</html>
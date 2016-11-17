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
// ARRAY DE USUARIOS QUE SAIRÃO NESSE DASHBOARD // POR USER_ID
$users_dash = array(2,3);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    
</head>

<?php include ('../layout/header.php'); ?>
<blockquote></blockquote>
<br/>

    <body>
        <div class="container">
            <div class="row">
            <h3>Teste</h3>
            <h5>Hoje é <?php echo $datacorrente ?></h5>
            <h5>Usuários no array: <?php foreach ($users_dash as $i => $value) {
                                            echo $value;
                                            echo ' ';
//                                            echo ($users_dash[$i].'  ');
//                                            print_r($users_dash);
                                        } ?></h5>
            </div>
        </div>
        
        
        <div class="container">
        <div class="row">
            <h5>Qtdade de Chamadas no dia de HOJE do usuário 2: </h5>
        <table class="table table-bordered">
            <?php
                    
                    include '../database.php';
                    $pdo1 = Database::connect();
//                    $sqluser = $pdo1->prepare('SELECT user_id FROM usuarios inner join tickets on usuarios.user_id=tickets.user_id');
                    //SELECT * FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall='2015-03-20' and calls.user_id='2';
                    $sqluser = $pdo1->prepare("SELECT count(*) FROM usuarios inner join calls on usuarios.user_id=calls.user_id where calls.datecall='2015-03-20' and calls.user_id='2'");
                    $parametros = array( $datacorrente );
                    $sqluser->execute( $parametros );
                    $qtdade = $sqluser->fetchColumn();
                    echo $qtdade;
//                    while ( $row = $sqluser->fetch()) {
//                        echo '<tr>';
//                        echo '<td></td>';
//                        echo '<tr>';
//                    }
                    
                    ?>
            
        </table>
        </div>
        </div>
        



    <?php include ('../layout/footer.php'); ?>
    </body>
</html>
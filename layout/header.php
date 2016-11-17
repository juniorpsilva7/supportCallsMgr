<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php $page = $_SERVER['REQUEST_URI']; ?>

<!DOCTYPE html>
<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
    <link   href="../css/bootstrap.min.css" rel="stylesheet">
    <link   href="../css/bootstrap.css" rel="stylesheet">
    


<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="span4 offset2">
    <img src="../img/logo_hon.png"/>
    </div>
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!--<img src="http://localhost:8080/supp1.1/img/logo_hon.jpg" align="left"/>-->
          <!--<a class="brand" href="http://localhost:8080/supp1.1/index.php">Home</a>-->
          <div class="nav-collapse collapse">
            <ul class="nav">
<!--              <li class="active"><a href="http://localhost/supp1.1/index.php">Home</a></li>
              <li><a href="http://localhost/supp1.1/tickets/index.php">Tickets</a></li>-->
              <li <?php echo ($page == '/supp1.1/index.php') ? 'class="active"' : '';?> ><a href="../index.php">Calls</a></li>
              <li <?php echo ($page == '/supp1.1/tickets/index.php') ? 'class="active"' : '';?> ><a href="../tickets/index.php">SF Cases</a></li>
<!--              <li><a href="#contact">Contact</a></li>-->
              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dashboards<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="../dashboards/dashboard1.php">Dashboard 1</a></li>
                  <li><a href="../dashboards/dashboard2.php">Dashboard 2</a></li>
<!--                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>-->
                </ul>
              </li>
              
            </ul>
            <div class="navbar-form pull-right">
                <span class="label label-inverse">Olá <b><?php echo $_SESSION['nome_usuario']?></b>,&nbsp&nbsp&nbsp; <a href="../login/sair.php">Logout</a></span>
            </div>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
<!--    <script src="http://localhost/supp1.1/js/jquery-1.11.2.js"></script>
    <script src="http://localhost/supp1.1/js/bootstrap.js"></script>-->
    <script src="../js/jquery-1.11.2.js"></script>
    <script src="../js/bootstrap.js"></script>
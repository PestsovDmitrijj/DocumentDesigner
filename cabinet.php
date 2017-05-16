<?php
/*function header_call(){
	header('Location: index.php');
}*/
session_start();
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
require_once './classes/Auth.class.php';
?><!DOCTYPE html>
<html>
  <head>
  
    <meta charset="utf-8">
    <title>Личный кабинет</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">
	<style>
		body {
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
			font-family: Arial;
		}

	</style>
 </head>
  <body>
  <div id="head">
<div id="header"></div>
</div>

<?php if (Auth\User::isAuthorized()): ?>
 
 
 
  <form class="ajax" method="post" action="./ajax.php">
          <input type="hidden" name="act" value="logout">
          
		  
    </form>
<?php if ($_SESSION['idRole']==1) : ?>

<div class='navbar navbar-default navbar-fixed-top'>
		<div class="btn-group">
			<button id='settings' size=20% type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle "> <img src='/css/img/menu.png'> <!--<span class="caret">--></span></button>
					<ul class="dropdown-menu">
							<li><a href="cabinet.php">Личный кабинет</a></li>
							<li><a href="tables.php">Управление информацией из базы данных</a></li>
							<li><a href="datauser.php">Управление пользователями</a></li>
							<li><a href="view_database.php">Просмотр базы данных</a></li>
							<li><a href="return.php">Сменить пароль</a></li>
							<li class="divider"></li>
							<li><a href="#">Выход</a></li>
					</ul>
		</div>
			<font color=white size=5> Добро пожаловать, <?php echo $_SESSION['username']; ?> </font>		
	</div>
	
  <div id='content' class='container'>
		<h3>Личный кабинет</h3>
		<div class='row'>
			
			<div class='col'>
					<ul class='nav nav-pills nav-stacked'>
						<li role="nav" class="active"><a href='webform2.php'>Создать программу государственной итоговой аттестации по специальности</a></li>
						<li role="nav" class="active"><a href='webform.php'>Создать рабочую программу учебных дисциплин или профессиональных модулей</a></li>
						<li role="nav" class='active'><a href='Editor.php'>Создать веб-страницу</a></li>
					</ul>
			</div>
		
		</div><br><br>
 </div> 

<!--=======
<ul class="nav nav-pills nav-stacked">

  <li role="nav" class="active"><a href='webform2.php'>Создать программу государственной итоговой аттестации по специальности</a></li>
  <li role="nav" class="active"><a href='webform.php'>Создать рабочую программу учебных дисциплин или профессиональных модулей</a></li>
  <li role="nav"><a href='Redactor.php'>Создать веб-страницу</a></li>
  <li role="nav"><a href='tables.php'>Управление информацией из базы данных</a></li>
  <li role="nav"><a href='datauser.php'>Управление пользователями</a></li>
  <li role="nav"><a href='return.php'>Сменить пароль</a></li>
</ul>
>>>>>>> 902c4f9375d9f13da6d948893c8c1b7d96f81cb8 -->
<?php endif; ?>
<?php if ($_SESSION['idRole']==2) : ?>
	<div class='navbar navbar-default navbar-fixed-top'>
		<div class="btn-group">
			<button id='settings' size=20% type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle "> <img src='/css/img/menu.png'></span></button> Добро пожаловать, <?php echo $_SESSION['username']; ?>! Это ваш личный кабинет.
					<ul class="dropdown-menu">
							<li><a href="#">Личный кабинет</a></li>
							<li><a href="#">Управление информацией из базы данных</a></li>
							<li><a href="#">Управление пользователями</a></li>
							<li><a href="#">Просмотр базы данных</a></li>
							<li><a href="#">Сменить пароль</a></li>
							<li class="divider"></li>
							<li><a href="#">Выход</a></li>
					</ul>
		</div>
					
	</div>
	
  <div id='content' class='container'>
	
  
  
  
		<h3> Добро пожаловать, <?php echo $_SESSION['username']; ?>! Это ваш личный кабинет.</h3>
		<div class='row'>
			<div class='col-sm-1 col-md-1 col-lg-1'>
				
				
			</div>
			<div class='col-sm-11 col-md-11 col-lg-11'>
					<ul class='nav nav-pills nav-stacked'>
						<li role="nav" class="active"><a href='webform2.php'>Создать программу государственной итоговой аттестации по специальности</a></li>
						<li role="nav" class="active"><a href='webform.php'>Создать рабочую программу учебных дисциплин или профессиональных модулей</a></li>
<!--						<li role="nav" class='active'><a href='Editor.php'>Создать веб-страницу</a></li>
	/-->				</ul>
		</div>
  
  
  
  </div>
  
<?php endif; ?>
<?php if ($_SESSION['idRole']==3) : ?>
	<div class='navbar navbar-default navbar-fixed-top'>
		<div class="btn-group">
			<button id='settings' size=20% type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle "> <img src='/css/img/menu.png'></span></button> Добро пожаловать, <?php echo $_SESSION['username']; ?>! Это ваш личный кабинет.
					
					<ul class="dropdown-menu">
							<li><a href="#">Управление информацией из базы данных</a></li>
							<li><a href="#">Управление пользователями</a></li>
							<li><a href="#">Просмотр базы данных</a></li>
							<li><a href="#">Сменить пароль</a></li>
							<li class="divider"></li>
							<li><a href="#">Выход</a></li>
					</ul>
		</div>
					
	</div>
	
  <div id='content' class='container'>
	
  
  
  
		<h3> Добро пожаловать, <?php echo $_SESSION['username']; ?>! Это ваш личный кабинет.</h3>
		<div class='row'>
			<div class='col-sm-1 col-md-1 col-lg-1'>
				
				
			</div>
			<div class='col-sm-11 col-md-11 col-lg-11'>
					<ul class='nav nav-pills nav-stacked'>
						<li role="nav" class="active"><a href='webform2.php'>Создать программу государственной итоговой аттестации по специальности</a></li>
						<li role="nav" class="active"><a href='webform.php'>Создать рабочую программу учебных дисциплин или профессиональных модулей</a></li>
<!--						<li role="nav" class='active'><a href='Editor.php'>Создать веб-страницу</a></li>
	/-->				</ul>
		</div>
  
  
  
  </div>
  
<?php endif; ?>
<?php else : header('Location: index.php'); 
//	header_call();
?>
<?php endif; ?>
 </div> <!-- /container -->
    <script src="./vendor/jquery-2.0.3.min.js"></script>
<script src="./vendor/jquery.json-1.3.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./js/ajax-form.js"></script>
<script src="./js/js_scripts.js"></script>

  </body>
</html>
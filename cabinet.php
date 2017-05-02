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
    <link rel="stylesheet" href="./vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
  <div id="head">
<div id="header"></div>
</div>
    <div class="container">
<?php if (Auth\User::isAuthorized()): ?>
 <h1>Добро пожаловать, <?php echo $_SESSION['username']; ?>! Это ваш личный кабинет.
 </h1>
 
  <form class="ajax" method="post" action="./ajax.php">
          <input type="hidden" name="act" value="logout">
          
		  
    </form>
<?php if ($_SESSION['idRole']==1) : ?>
<<<<<<< HEAD
<div class="sidebar">
<ul>
  <li role="nav" class="active"><a href='webform2.php'>Создать программу государственной итоговой аттестации по специальности</a></li>
  <li role="nav" class="active"><a href='webform.php'>Создать рабочую программу учебных дисциплин или профессиональных модулей</a></li>
  <li role="nav"><a href='Redactor.php'>Создать веб-страницу</a></li></ul>
  </div>
  <div class="buttons">
	<ul>
		<li role="nav"><a href='tables.php'>Управление информацией из базы данных</a></li>
		<li role="nav"><a href='datauser.php'>Управление пользователями</a></li>
		<li role="nav"><a href='view_database.php'>Просмотр базы данных</a></li>
		<li role="nav"><a href='return.php'>Сменить пароль</a></li>
	</ul>
</div>
=======
<ul class="nav nav-pills nav-stacked">

  <li role="nav" class="active"><a href='webform2.php'>Создать программу государственной итоговой аттестации по специальности</a></li>
  <li role="nav" class="active"><a href='webform.php'>Создать рабочую программу учебных дисциплин или профессиональных модулей</a></li>
  <li role="nav"><a href='Redactor.php'>Создать веб-страницу</a></li>
  <li role="nav"><a href='tables.php'>Управление информацией из базы данных</a></li>
  <li role="nav"><a href='datauser.php'>Управление пользователями</a></li>
  <li role="nav"><a href='return.php'>Сменить пароль</a></li>
</ul>
>>>>>>> 902c4f9375d9f13da6d948893c8c1b7d96f81cb8
<?php endif; ?>
<?php if ($_SESSION['idRole']==2) : ?>
<div class="sidebar">
<ul class="nav nav-pills nav-stacked">
  <li role="nav" class="active"><a href='webform2.php'>Создать программу государственной итоговой аттестации по специальности</a></li>
  <li role="nav" class="active"><a href='webform.php'>Создать рабочую программу учебных дисциплин или профессиональных модулей</a></li>
  <li role="nav"><a href='Redactor.php'>Создать веб-страницу</a></li>
  </div>
  <li role="nav"><a href='tables.php'>Управление информацией из базы данных</a></li>
  <li role="nav"><a href='return.php'>Сменить пароль</a></li>
</ul>
<?php endif; ?>
<?php if ($_SESSION['idRole']==3) : ?>
<div class="sidebar">
<ul class="nav nav-pills nav-stacked">
  <li role="nav" class="active"><a href='webform2.php'>Создать программу государственной итоговой аттестации по специальности</a></li>
  <li role="nav" class="active"><a href='webform.php'>Создать рабочую программу учебных дисциплин или профессиональных модулей</a></li> 
  </div>
  <li role="nav"><a href='return.php'>Сменить пароль</a></li>
</ul>
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
<div class="form-actions"><button class="btn btn-large btn-primary" type="submit">Выход</button></div>
  </body>
</html>
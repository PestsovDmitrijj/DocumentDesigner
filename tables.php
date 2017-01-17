<html>
<head>
	<title>Управление данными</title>
	<meta charset=utf8>
	<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap-theme.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<link rel="stylesheet" href="./vendor/pure-release-0.6.0/pure-min.css">
	<style>
		body {
		padding-top: 40px;
		padding-bottom: 40px;
		background-color: #f5f5f5;
		font-family: Arial;
		}
	</style>
</head>
<script src="./vendor/jquery-2.0.3.min.js"></script>
<script src="./vendor/jquery.json-1.3.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./js/ajax-form.js"></script>
<script src="./js/js_scripts.js"></script>
<body>
<?php
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';
?>
<?php if (Auth\User::isAuthorized()): ?>
<?php if ($_SESSION['idRole']==1 || $_SESSION['idRole']==2) : ?>
<div class="container">
<h3>Вы авторизованы под учетной записью пользователя <?php echo $_SESSION['username']; ?>.</h3>
	<form class="ajax" method="post" action="./ajax.php">
          <input type="hidden" name="act" value="logout">
          <div class="form-actions">
              <button class="btn btn-large btn-primary" type="submit">Выход</button>
          </div>
		  <br>
			<ul class="nav nav-pills">
				<li role="nav" class="active"><a href = 'cabinet.php'>Личный кабинет</a></li>
			</ul>
    </form>
<h1>Управление информацией в базе данных</h1>
<hr>
	<div class="col-md-12">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Специальности</h3>
            </div>
            <div class="panel-body">
             <table class = 'table table-bordered'>			
					<tr>
						<td>Управление: 
							<ul style='padding-left: 15px;'>
								<li>списком специальностей;</li>
								<li>списками общих и профессиональных компетенций выбранной специальности;</li>
								<li>наборами учебных помещений и учебных дисциплин выбранной специальности;</li>
								<li>наборами общих и профессиональных компетенций, знаний, умений для конкретной дисциплины выбранной специальности.</li>
							</ul>
						</td>
						<td>
							<button type = button class = 'btn btn-primary' onclick="parent.location='spectables.php'" >Перейти</button>
						</td>
					</tr>
				</table>
            </div>
         </div>
	</div>
	<div class="col-md-12">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Дисциплины</h3>
            </div>
            <div class="panel-body">
				<table class = 'table table-bordered'>			
					<tr>
						<td>Управление:
							<ul style='padding-left: 15px;'>
								<li>общим списком дисциплин;</li>
								<li>списком типов и циклов учебных дисциплин;</li>
								<li>списком индексов учебных дисциплин для дальнейшего использования в наборах дисциплин конкретных специальностей;</li>
								<li>списками знаний и умений для конкретной дисцплины для дальнейшего использования в наборах дисциплин специальностей.</li>
							</ul>
						</td>
						<td><button type = button class = 'btn btn-primary' onclick = "parent.location='datasubj.php'">Перейти</button></td>
					</tr>
				</table>
            </div>
         </div>
	</div>
	<div class="col-md-12">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Компетенции</h3>
            </div>
            <div class="panel-body">
				<table class = 'table table-bordered' id = 'tableEqMas'>			
					<tr>
						<td>Управление:
							<ul style='padding-left: 15px;'>
								<li>общим списком общих компетенций для дальнейшего использования в наборах ОК конкретных специальностей и дисциплин;</li>
								<li>списком индексов профессиональных компетенций для дальнейшего использования в наборах ПК конкретных специальностей.</li>
							</ul>
						</td>
						<td><button type = button class = 'btn btn-primary'  onclick="parent.location='datacompet.php'">Перейти</button></td>
					</tr>
				</table>
            </div>
         </div>
	</div>
	<div class="col-md-12">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Помещения</h3>
            </div>
            <div class="panel-body">
             <table class = 'table table-bordered' id = 'tableEqMas'>			
					<tr>
						<td>Управление:
							<ul style='padding-left: 15px;'>
								<li>общим списком учебных помещений для дальнейшего использования в наборах помещений конкретных специальностей;</li>
								<li>списком типов учебных помещений.</li>
							</ul>
						</td>
						<td>
							<button type = button class = 'btn btn-primary' onclick="parent.location='datacroom.php'" >Перейти</button>
						</td>
					</tr>
				</table>
            </div>
         </div>
	</div>
</div>
<?php else : header('Location: cabinet.php');?>
<?php endif; ?>
<?php else : header('Location: index.php'); ?>
<?php endif; ?>
</body>
</html>
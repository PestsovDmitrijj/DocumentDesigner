<?php
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';
?><!DOCTYPE html><html>
<head>
	<title>Специальности</title>
	<meta charset=utf8>
	<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap-theme.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<link rel="stylesheet" href="./vendor/pure-release-0.6.0/pure-min.css">
	<style type="text/css">
		body {
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
			font-family: Arial;
		}
		.BUTTCOL{
			width: 100px;
		}
		#messageBlock{
			/*visibility: hidden;*/
			display: none;
    width:450px;
    height:120px;
    position:fixed;
	z-index:999;
    right:0;
    bottom:0;
		}
	</style>
</head>
<script src="./vendor/jquery-2.0.3.min.js"></script>
<script src="./vendor/jquery.json-1.3.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./js/ajax-form.js"></script>
<script src="./js/js_scripts.js"></script>
<body>
<div class="container">
	<?php if (Auth\User::isAuthorized()): ?>
	<div id = 'messageBlock' class="alert alert-success"></div>
	 <h3>Вы авторизованы под учетной записью пользователя <?php echo $_SESSION['username']; ?>.</h3>
	 <form class="ajax" method="post" action="./ajax.php">
          <input type="hidden" name="act" value="logout">
          <div class="form-actions">
              <button class="btn btn-large btn-primary" type="submit">Выход</button>
          </div><br>
			<ul class="nav nav-pills">
				<li role="nav" class="active"><a href = 'cabinet.php'>Личный кабинет</a></li>
				<li role="nav"><a href = 'tables.php'>Управление информацией из базы данных</a></li>
			</ul>
    </form>
<?php if ($_SESSION['idRole']==1 || $_SESSION['idRole']==2) : ?>
	<h1>Список специальностей</h1>
	<hr>
		<div class="col-md-10">
			<div class="panel panel-primary">
				<div class="panel-heading">
				  <h3 class="panel-title">Список специальностей</h3>
				</div>
				<div id = "EditSpecForm"></div>
			</div>
		</div>
	<div class="col-md-10">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Добавление новой специальности</h3>
            </div>
            <div class="panel-body">
				<input  style="width: 250px" id="textSpecCode" placeholder = "Код специальности">
				<input style="width: 500px" id="textSpec" placeholder = "Наименование специальности">
				<button class = 'btn btn-primary' id = 'addSpecialtyButt' onclick = switchData(this.id); >Добавить</button>
            </div>
         </div>
	</div>
	<?php else : header('Location: cabinet.php');?>
	<?php endif; ?>
	<?php else : header('Location: index.php'); ?>
	<?php endif; ?>
	</div>
<script>
	setInterval(function(){ 
		$("#panel panel-primary").load("spectables.php #panel panel-primary"); 
	}, 1000);
</script>
</body>
</html>
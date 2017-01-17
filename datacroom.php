<html>
<head>
	<title>Помещения</title>
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
<script>	
	$(window).load(function(){
		$('#CRType1').change(function(){
			idCRType = $('#CRType1 option:selected').attr('id');
			$.ajax({
				type: "POST",				
				url: "getData.php",
				data: 'func=12&idCRType='+idCRType,
				cache: false,
				success: function(data){
					$('#CRTable').html(data);
				}
			});
		});
	});
</script>
<body>
<?php
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';
include_once './getData.php';
?>
<?php if (Auth\User::isAuthorized()): ?>
<?php if ($_SESSION['idRole']==1 || $_SESSION['idRole']==2) : ?>
<div class="container">
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
<h1>Управление данными об учебных помещениях и их типах</h1>
<hr>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Типы учебных помещений</h3>
		</div>
		<div class="panel-body">
			<div id = 'CRTForm' class = "rows">
				<div class="col-md-5">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Добавление новых типов учебных помещений</h3>
						</div>
						<div class="panel-body">
							<p> Внести новый тип:</p>
							<input id = 'CRTtext' type = 'text' placeholder = 'Например, кабинеты' size = '35'>
							<button id = 'CRTButton' onclick = switchData(this.id);>Сохранить</button>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Список типов помещений</h3>
						</div>
						<div class="panel-body">
							<table id = "CRTypeTable" class = 'table table-bordered'><tr><th>Наименование типа (для редактирования - 1 клик)</th><th class = 'BUTTCOLL'>Операции</th></tr><?php CRoomType_Table(); ?></table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Учебные помещения</h3>
		</div>
		<div class="panel-body">
			<div id = 'CRForm' class = "rows">
				<div class="col-md-5">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Добавление новых учебных помещений</h3>
						</div>
						<div class="panel-body">
							<p> Выберите тип помещения:</p>
							<select id = 'CRType1' style="width: 300px" name = 'CRT' class = "CRTclass">
								<option id='0' selected="selected" value ='empty'>Выбрать тип помещения</option>
							</select>
							<p> Внести новое учебное помещение:</p>
							<input id = 'CRoomtext' type = 'text' placeholder = 'Например, математических дисциплин' size = '35'>
							<button id = 'CRButton' onclick = switchData(this.id);>Сохранить</button>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Список помещений</h3>
						</div>
						<div class="panel-body" style = 'height: 600px; overflow: auto;'>
							<table id = "CRTable" class = 'table table-bordered'><tr><th class = "CODECOL">Тип уч. помещения</th><th>Наименование уч. помещения (для редактирования - 1 клик)</th><th class = 'BUTTCOLL'>Операции</th></tr></table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php else : header('Location: cabinet.php');?>
<?php endif; ?>
<?php else : header('Location: index.php'); ?>
<?php endif; ?>
</div>
</body>
</html>

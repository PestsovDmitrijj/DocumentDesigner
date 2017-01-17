<html>
<head>
	<title>Компетенции</title>
	<meta charset=utf8>
	<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap-theme.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
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
	<link rel="stylesheet" href="pure-release-0.6.0/pure-min.css">
</head>
<script src="./vendor/jquery-2.0.3.min.js"></script>
<script src="./vendor/jquery.json-1.3.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./js/ajax-form.js"></script>
<script src="./js/js_scripts.js"></script>
<script>	
	$(window).load(function(){
		$('.gcrows').dblclick(function(e){
			var elem = this.id,
			parentrow = this.parentNode,
			idContMark = parentrow.childNodes[2].childNodes[1].value;
			$.ajax({	
				type: "POST",				
				url: "getData.php",
				data: 'func=15&idContMark='+idContMark,
				cache: false,
				success: function(data){
					document.getElementById(elem).innerHTML = data;
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
include_once './getData.php';
require_once './classes/Auth.class.php';
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
<h1>Управление данными об ОК и индексах ПК</h1>
<hr>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Общие компетенции</h3>
		</div>
		<div class="panel-body">
			<div id = 'GCompForm1' class = "rows">
				<div class="col-md-5">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Добавление новых общих компетенций (ОК)</h3>
						</div>
						<div class="panel-body">
							<p> Впишите код и содеражание компетенции:</p>
							<input id = 'GCCodetext' type = 'text' placeholder = 'ОК 1' size = '35'>
							<br><br>
							<select  class = 'conmarksel' style = "width: 390px;"></select>
							<textarea id = 'GCtext' style = "width: 390px; height: 80px;"></textarea>
							<br><br>
							<button id = 'addGenCompButt' onclick = switchData(this.id);>Сохранить</button>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Список общих компетенций</h3>
						</div>
						<div class="panel-body" style = 'height: 600px; overflow: auto;'>
							<table id = "GCompTable" class = 'table table-bordered'><tr><th class = "CODECOL">Код</th><th>Содержание (для редактирования - 1 клик)</th><th>Контроль и оценка (для редактирования - 2 клика)</th><th class = 'BUTTCOLL'>Операции</th></tr><?php GC_Table3(); ?></table>
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
			<h3 class="panel-title">Индексы ПК</h3>
		</div>
		<div class="panel-body">
			<div id = 'PCCodeForm' class = "rows">
				<div class="col-md-5">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Добавление новых индексов ПК</h3>
						</div>
						<div class="panel-body">
							<p> Впишите индекс ПК:</p>
							<input id = 'PCCodetext' type = 'text' placeholder = 'ПК 1.1' >
							<br><br>
							<button id = 'addPCCodeButt' onclick = switchData(this.id);>Сохранить</button>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Список индексов ПК</h3>
						</div>
						<div class="panel-body" style = 'height: 600px; overflow: auto;'>
							<table id = "PCCodeTable" class = 'table table-bordered'><tr><th class = "CODECOL">Код (для редактирования - 1 клик)</th><th class = 'BUTTCOLL'>Операции</th></tr><?php PCCode_Table(); ?></table>
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

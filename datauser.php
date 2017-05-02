<? session_start(); ?>
<html>
<head>
	<title>Управление пользователями</title>
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
<?php

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}

require_once './classes/Auth.class.php';

include_once './getData.php';

?>

<?php if (Auth\User::isAuthorized()): ?>
<?php if ($_SESSION['idRole']==1) : ?>
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
		  <li role="nav"><a href = 'register.php'>Зарегистрировать новых пользователей</a></li>
		</ul>
    </form>
<h1>Список пользователей системы</h1>
<hr>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
		  <h3 class="panel-title">Список пользователей</h3>
		</div>
		<div id = "EditUserForm">
		<table class = 'table table-bordered' id = 'Users' ><tr><th>ID</th><th>username</th><th>Имя</th><th>Фамилия</th><th>Отчество</th><th>Роль</th><th>Операции</th></tr><?php User_Table(); ?></table>
		</div>
	</div>
</div>
</div>
<?php else : header('Location: cabinet.php');?>
<?php endif; ?>
<?php else : header('Location: index.php'); ?>
<?php endif; ?>
</body>
<script>
		$('.rolerows1').dblclick(function(e){
			var elem = this.id;
			var parentrow = this.parentNode;
			var idRole = parentrow.childNodes[5].childNodes[1].value;
			$.ajax({	
				type: "POST",				
				url: "getData.php",
				data: 'func=22&idRole='+idRole,
				cache: false,
				success: function(data){
					document.getElementById(elem).innerHTML = data;
				}
			});	
		});
</script>
</html>

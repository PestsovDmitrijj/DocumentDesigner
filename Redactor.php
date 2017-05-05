<<<<<<< HEAD
<?php

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';


include "./CreatorOfWebPages/Functions.php";

?>
=======
>>>>>>> 902c4f9375d9f13da6d948893c8c1b7d96f81cb8
<html>

<head>

<title>Редактор веб-страниц</title>
<meta charset='utf-8'>
<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap-theme.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link rel="stylesheet" href="./vendor/pure-release-0.6.0/pure-min.css">
</head>


<style>

	th {
		text-align: center;
	}

	.thTemPlan {
		background-color: white;
	}

	.thEq {
		width: 15%;
	}

	.eq {
		width: 100%;
		height: 100%;
	}

	.eqBut {
		width: 10%;
	}
	
	.headerText {
		text-align: center; 
		font-size: 16px;
	}

	input {
		text-align: center;
	}
	td {
		text-align: center;
	}
/* 	th {
		background-color:#337ab7;
		color: white;
		text-align: center;
	} */
	body {
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
			font-family: Arial;
		}
	
    
	
</style>
<<<<<<< HEAD

=======
<?php

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';
?>
>>>>>>> 902c4f9375d9f13da6d948893c8c1b7d96f81cb8
<?php if (Auth\User::isAuthorized()): ?>
<script src="./vendor/jquery-2.0.3.min.js"></script>
<script src="./vendor/jquery.json-1.3.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./js/ajax-form.js"></script>
<script src="./js/js_scripts.js"></script>
<script src="FunctionsForWebforms.js"></script>



<body>


<div class="container">

<h3>Вы авторизованы под учетной записью пользователя <?php echo $_SESSION['username']; ?>.</h3>
<form class="ajax" method="post" action="./ajax.php">
	<input type="hidden" name="act" value="logout">
	<div class='row'>
		<div class="form-actions">
			<button class="btn btn-large btn-primary" type="submit">Выход</button>
			<ul class="nav nav-pills">
			<li role="nav" class="active"><a href = 'cabinet.php'>Личный кабинет</a></li>
			</ul>
		</div><br>
		
	</div>
</form>
<<<<<<< HEAD
<div class="row"> 
	<div class="col-md-12"> 
		<div class="panel panel-primary"> 
			<div class="panel-heading"> 
				<h3 class="panel-title">Имя файла(example.php)</h3> 
</div> 
			<div class="panel-body"> 
				<input required style='width:100%' id = 'company' name = 'company'> 
			</div> 
		</div> 
	</div> 
</div>

<input class="btn btn-large btn-primary" type=submit value='добавить шапку' name='hat' size=20>
<input class="btn btn-large btn-primary" type=submit value='добавить элемент' name='element'>
<input class="btn btn-large btn-primary" type=submit value='добавить подвал' name='basement'>


<br><br>


=======
>>>>>>> 902c4f9375d9f13da6d948893c8c1b7d96f81cb8

<form method="POST" action="/CreatorOfWebPages/Printer.php" >
<button id = 'submit'  class = 'btn btn-lg btn-success' >
	<i class="fa fa-file-text" aria-hidden="true"> Создать документ</i>
</button>
</form>
</div>



<?php else : header('Location: index.php'); ?>
<?php endif; ?>

</body>

</html>
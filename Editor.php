<?php
include 'Functions.php';
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';

include './classes/web/includerWeb.php';
//include './classes/web/testElementController.php';

$controller = new WebController();

?>
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

<?php if (Auth\User::isAuthorized()): ?>
<script src="./vendor/jquery-2.0.3.min.js"></script>
<script src="./vendor/jquery.json-1.3.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./js/ajax-form.js"></script>
<script src="./js/js_scripts.js"></script>



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
<form action="" method=POST id="add_field_input">

<div class="row"> 
	<div class="col-md-4"> 
		<div class="panel panel-primary"> 
			<div class="panel-heading"> 
				<h3 class="panel-title">Имя файла(example.php)</h3> 
			</div> 
			<div class="panel-body"> 
				<input  style='width:68%' type=text id ='filename' name ='filename'>
				<input class="btn btn-large btn-primary" type=submit value='запомнить' name='remember' size=20 id="remember"
					onclick="rememberName(add_field_input)">				
			</div> 
				
		</div> 
		
	</div> 
		<div class="col-md-8"> 
		<div class="panel panel-primary"> 
			<div class="panel-heading"> 
				<h3 class="panel-title">Панель редактирования веб-формы</h3> 
			</div> 
			<div class="panel-body"> 
				<input class="btn btn-large btn-primary" type=submit value='Добавить раздел' name='add_Section' size=20 id="add_Section">
				<input class="btn btn-large btn-primary" type=submit value='Добавить поле ввода' name='add_Input' size=20 id="add_Input">
				<input class="btn btn-large btn-primary" type=submit value='Добавить текстовое окно' name='add_Content' size=20 id="add_Content">
		<!--	<input class="btn btn-large btn-primary" type=submit value='Сохранить изменения' name='save' size=20 id="save">
				<input class="btn btn-large btn-primary" type=submit value='не сохранять' name='do_not_save' size=20 id="do_not_save">
			/-->
			</div> 
				
		</div> 
		
	</div>
</div>
<?php
if ( isset($_POST['add_Section']) ){
	$controller->createForm( "PanelHeading:Добавление раздела|InputField:submit-addSection|Col:6" );
}
if ( isset($_POST['add_Input']) ){
	$controller->createForm( "InputField:text-addInpFd|InputField:submit-addSection|Col:8" );
}
if ( isset($_POST['add_Content']) ){
	
}

function remember() {
	$name = $_POST['filename'];
	return $name;
}

function getHiddName() {
	$name = $_POST['store_name'];
	return $name;
}

if( isset( $_POST['remember'] ) ) {
	$name = remember();
}


if( isset( $_POST['add'] ) ) {
	$name = getHiddName();
}

?>

<input type=hidden name='store_name' id="store_name" value ='<? echo $name; ?>' >
<input type=hidden name='store_page' id="store_page" value='<? echo $content; ?>'>
<input type=hidden name='worksheetID' id="worksheetID" value='<? echo $worksheetID; ?>'>

<input type=submit class="btn btn-large btn-primary" name='submit' id="submit" value ='Создать страницу' >

</form>

<hr>

<?php

echo "<h3><center>" . $_POST['store_name'] . "</center></h3>";

?>

</div>



<?php else : header('Location: index.php'); ?>
<?php endif; ?>

</body>

</html>
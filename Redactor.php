<?php

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';


include "./CreatorOfWebPages/Functions.php";

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
<form action="" method=POST>
<div class="row"> 
	<div class="col-md-6"> 
		<div class="panel panel-primary"> 
			<div class="panel-heading"> 
				<h3 class="panel-title">Имя файла(example.php)</h3> 
</div> 
			<div class="panel-body"> 
				<input  style='width:100%' type=text id ='filename' name ='filename'>
				<input class="btn btn-large btn-primary" type=submit value='запомнить' name='remind' size=20 id="remind">		
			</div> 
		</div> 
	</div> 
</div>

<input class="btn btn-large btn-primary" type=submit value='добавить шапку' name='add_head' size=20 id="add_head">
<input class="btn btn-large btn-primary" type=submit value='добавить поле ввода <текст>' name='add_text' id="add_text">
<input class="btn btn-large btn-primary" type=submit value='добавить поле ввода <дата>' name='add_date' id="add_date">
<input class="btn btn-large btn-primary" type=submit value='добавить поле ввода <селектор>' name='add_selector' id="add_selector">
<input class="btn btn-large btn-primary" type=submit value='добавить подвал' name='basement' id='basement'>

</form>
<hr>

<?php 

if( isset( $_POST['remind'] ) ) {
	$fileName = $_POST['filename'];
	echo $fileName;
}

if( isset( $_POST['add_head'] ) ) {
	echo $fileName;
	if ( file_exists($fileName) ) {
		echo "<meta charset=utf-8><font size=5 color=red>Файл с таким именем уже существует!</font>";
	} else {
		echo "ВЫШЛО ЕЛСЕ";
		echo $fileName;
		$file = startCreateWebForm($fileName);
	}
}

if( isset( $_POST['add_text'] ) ) {
	$content = "<div class='row'><div class='col-md-6'>
	<div class='panel panel-primary'><div class='panel-heading'>
	<input required style='width:100%' type=text>
	</div></div></div></div>";
	addContent($file, $content);
	echo $content;
}

if( isset( $_POST['add_date'] ) ) {
	$content ="<div class='row'><div class='col-md-6'>
	<div class='panel panel-primary'><div class='panel-heading'>
	<input required style='width:100%' type=date>
	</div></div></div></div>";
	addContent($file, $content);
	echo $content;
}

if( isset( $_POST['add_selector'] ) ) {
	$content = "<div class='row'><div class='col-md-6'>
	<div class='panel panel-primary'><div class='panel-heading'>
	<select></select>
	</div></div></div></div>";
	addContent($file, $content);
	echo $content;
}

if( isset( $_POST['basement'] ) ) {
	endCreateWebForm($file);
}

echo $fileName;
?>

</div>



<?php else : header('Location: index.php'); ?>
<?php endif; ?>

</body>

</html>
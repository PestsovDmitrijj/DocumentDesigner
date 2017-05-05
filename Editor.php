<?php

include 'Functions.php';

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';


include "./Functions.php";

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
	<div class="col-md-6"> 
		<div class="panel panel-primary"> 
			<div class="panel-heading"> 
				<h3 class="panel-title">Имя файла(example.php)</h3> 
</div> 
			<div class="panel-body"> 
				<input  style='width:80%' type=text id ='filename' name ='filename'>
				<input class="btn btn-large btn-primary" type=submit value='запомнить' name='remember' size=20 id="remember"
					onclick="rememberName(add_field_input)">				
			</div> 
				
		</div> 
		
	</div> 
</div>
<div class="row"> 
	<div class="col-md-8"> 
		<div class="panel panel-primary"> 
			<div class="panel-heading"> 
				<h3 class="panel-title">Добавление поля</h3> 
</div> 
			<div class="panel-body">
				Введите название поля:	
				<input  style='width:77%' type=text id ='inputname' name ='inputname'>
				Тип принимаемого значения:
				<input type=radio name="type" id="type" value=1>текст
				<input type=radio name="type" id="type" value=2>дата
				<input type=radio name="type" id="type" value=3>выпадающий список		
			</div> 
			<input class="btn btn-large btn-primary" type=submit value='Добавить' id="add" name="add">	
		</div> 
		
	</div> 
</div>


<?php

function recuperation($content) {
	$exp = explode( "~", $content );
	$i = count($exp)-1;
	$content = "";
	for ( $j=0; $j < $i; $j++ ){
		$sub_exp = explode( "|", $exp[$j] );
		$arr[$j]["name"] = $sub_exp[0];
		$arr[$j]["type"] = $sub_exp[1];
		$content .= "<div class='row'>
<div class='col-md-6'>
<div class='panel panel-primary'>
<div class='panel-heading'>		
<h3 class='panel-title'>".$arr[$j]["name"]."</h3>
</div>
<div class='panel-body'>";
		if( $arr[$j]["type"] == "select" ) {
			$content .= "<select></select>";
		} else {
			$content .= "<input type=".$arr[$j]["type"]." style='width:100%'>";
		}

function remember() {
	$name = $_POST['filename'];
	$file = startCreateWebForm($name);
	return $file;
}

function adding($file) {
		$inputname = $_POST['inputname'];
	$type = $_POST['type'];
	$content = $_POST['store_page'];
	if( $type == 1 ){
		$content = $content."
<div class='row'>
<div class='col-md-6'>
<div class='panel panel-primary'>
<div class='panel-heading'>		
<h3 class='panel-title'>".$inputname."</h3>
</div>
<div class='panel-body'>
<input type=text>

</div>
</div>
</div>
</div>";
	}
	
	echo $content;
	return $content;
	
}


function remember() {
	$name = $_POST['filename'];
	return $name;
}

function getHiddName() {
	$name = $_POST['store_name'];
	return $name;
}

function getHidden() {
	$content = $_POST['store_page'];
	return $content;
}

function adding($content) {
	$inputname = $_POST['inputname'];
	$type = $_POST['type'];
	if( $type == 1 ){
		$content = $content."$inputname|text~";
	}
	if( $type == 2 ){
		$content = $content."$inputname|date~";
	}
	if( $type == 3 ){
		$content = $content."$inputname|select~";
	}
	
	if( $type == 2 ){
		$content = $content."
<div class='row'>
<div class='col-md-6'>
<div class='panel panel-primary'>
<div class='panel-heading'>		
<h3 class='panel-title'>".$inputname."</h3>
</div>
<div class='panel-body'>
<input type=date>
</div>
</div>
</div>
</div>";
	}
	if( $type == 3 ){
		$content = $content."
<div class='row'>
<div class='col-md-6'>
<div class='panel panel-primary'>
<div class='panel-heading'>		
<h3 class='panel-title'>".$inputname."</h3>
</div>
<div class='panel-body'>
<select></select>
</div>
</div>
</div>
</div>";
	}
	echo $content;	
	addContent($file, $content);
	return $content;
}


if( isset( $_POST['remember'] ) ) {

	$name = remember();

	remember();

}


if( isset( $_POST['add'] ) ) {

	$name = getHiddName();
	$content = getHidden();
	$content = adding($content);
	recuperation($content);
}

if( isset( $_POST['submit'] ) ) {
	$fileName = getHiddName();
	$hidd = getHidden();
	
	if ( file_exists($fileName) ) {
		echo "<meta charset=utf-8><font size=5 color=red>Файл с таким именем уже существует!</font>";
	} else {
		$file = startCreateWebForm($fileName);

		
		$content = recuperation($hidd);
		addContent($file, $content);

		endCreateWebForm($file);
		goToWebPage ($fileName);
	}
}

	adding($file);
}





?>

<input type=hidden name='store_name' id="store_name" value ='<? echo $name; ?>' >
<input type=hidden name='store_page' id="store_page" value='<? echo $content; ?>'>

<input type=submit class="btn btn-large btn-primary" name='submit' id="submit" value ='Создать страницу' >

<input type=hidden name='restore_name' id="store_name" value ="<? echo $name; ?>" >
<input type=hidden name='restore_page' id="store_page" value="<? echo $content; ?>">


</form>

<form action="./CreatorOfWebPages/Printer.php" method=POST>
<button id = 'submit'  class = 'btn btn-lg btn-success' >
	<i class="fa fa-file-text" aria-hidden="true"> Создать страницу</i>
</button>
</form>

<hr>



</div>



<?php else : header('Location: index.php'); ?>
<?php endif; ?>

</body>

</html>
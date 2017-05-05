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

<title>Компитенции</title>
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

<?php

@$con=mysql_connect('localhost','root', '')
  or die ("Ошибка". mysql_errno().":".mysql_error()."<br>");
@mysql_select_db('Plan', $con)
  or die ("Ошибка". mysql_errno().":".mysql_error()."<br>");

function select_all($table_name) {
	global $con;
	return mysql_query("SELECT * FROM " . $table_name, $con);
}

function each_row($table_name, $callback) {
	$query = select_all($table_name);
	for ($row = mysql_fetch_assoc($query);
	     $row;
	     $row = mysql_fetch_assoc($query)) {
			$callback($row);
	}
}

function create_html_table($table_name){
	global $result, $resolution;
	$result = "<table border=1>";
	$resolution = true;	
	each_row($table_name, function($row){
		global $result, $resolution;	
		$result .= "<tr>";
		if ($resolution == true){
			foreach($row as $key => $value){	
				global $result, $resolution; 
				$result .= "<th>$key</th>";
				$resolution = false;			
			}
		}
		$result .= "</tr><tr>";
		foreach($row as $value){	
			global $result; 
			$result .= "<td>$value</td>";
		}		
		$result .= "</tr>";
	});
	$result .= "</table>";
	return $result;
}


// $db = mysql_connect("localhost", "root","") OR DIE('Ошибка соединения');
// mysql_select_db("Plan", $db);
// mysql_query("SET NAMES 'utf8'",$db);





// $strSQL = "SELECT idGenComp, GCompCode, GCompCont, idContMark FROM GenComp";
// $rs = mysql_query($strSQL, $db);



// $table .= "<br>";
// $table .="<table border=1>";
// $table .="<tr>";
// $table .=	"<td>";
// $table .=		"что-то";
// $table .=	"</td>";
// $table .=	"<td>";
// $table .=		"что-то2";
// $table .=	"</td>";
// $table .=	"<td>";
// $table .=		"что-то3";
// $table .=	"</td>";
// $table .=	"<td>";
// $table .=		"что-то4";
// $table .=	"</td>";
// $table .="</tr>";

// while($row = mysql_fetch_array($rs)) {
// $table .="<tr>";
// $table .="	<td>".$row['idGenComp']."</td>";

// $table .="	<td>".$row['GCompCode']."</td>";

// $table .="	<td>".$row['GCompCont']."</td>";

// $table .="	<td>".$row['idContMark']."</td>";
// $table .="</tr>";

 
	
// }
// echo $table; 


 ?>
<form method='POST' action="" name="form" id="form">


	<div class="panel panel-warning">
<?php

	echo "<h2>Общие компетенции</h2>";
	$table = create_html_table("GenComp");
	echo $table;
	echo "<br>";
	
?>
</div>
<div class="row">
	<div class="col-md-3">
	<div class="panel panel-warning">
<?php	
	echo "<h3>Общие компетенции по предметам</h3>";
	$table = create_html_table("Subj_GComp");
	echo $table;
	
?>
	</div>
	</div>
	<div class="col-md-3">
	<div class="panel panel-warning">
<?php	
	echo "<h3>Профессианальные компетенции по предметам</h3>";
	$table = create_html_table("Subj_PComp");
	echo $table;

?>
	</div>
	</div>
</div>

</form>
</div>



<?php else : header('Location: index.php'); ?>
<?php endif; ?>

</body>

</html>
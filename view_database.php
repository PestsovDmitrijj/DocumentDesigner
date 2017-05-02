<?session_start();?>
<html>
<title> Создание рабочей программы учебной дисциплины</title>
<head><meta charset=utf8></head>
<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap-theme.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link rel="stylesheet" href="./vendor/pure-release-0.6.0/pure-min.css">
<!--<link href="css/grid.css" rel="stylesheet">-->
<html>
<head>
<title>Форма просмотра БД</title>
<meta charset=utf-8>
</head>

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

?>
<body>
<h3>Вы авторизованы под учетной записью пользователя <?php echo $_SESSION['username']; ?>.</h3>

<form class="ajax" method="post" action="./ajax.php">
          <input type="hidden" name="act" value="logout">
          <div class="form-actions">
              <button class="btn btn-large btn-primary" type="submit">Выход</button>
          </div><br>
			<ul class="nav nav-pills">
				<li role="nav" class="active"><a href = 'cabinet.php'>Личный кабинет</a></li>
			</ul>
    </form>
<form method = "POST" action = "">

<form method='POST' action="" name="form" id="form">
<select name="input" id="input">
	<?php
		$query = mysql_query("SHOW TABLES;", $con);
		while ($row = mysql_fetch_array($query) ){
			echo "
				<option>".
				$row['Tables_in_plan']
				."</option>
			";
		}
	?>
</select>
<input type=submit  class="btn btn-large btn-primary" name="sub" id="sub" value="Показать">
<?php
if (isset($_POST['sub'])){
	$input = $_POST['input'];
	$table = create_html_table($input);
	echo $table;
}

?>
</form>


</body>

</html>

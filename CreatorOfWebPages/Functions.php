<?php
function goToWebPage ($fileName) {
	header("Location:".$fileName);
}

function startCreateWebForm ($fileName) {
	$file = fopen( $fileName, "x" );
	
	$pattern = "<html>
	<head>
		<title>$fileName</title>
		<meta charset='utf-8'>
<link rel='stylesheet' type='text/css' href='./vendor/bootstrap-3.3.6/css/bootstrap.min.css'>
<link rel='stylesheet' type='text/css' href='./vendor/bootstrap-3.3.6/css/bootstrap-theme.css'>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css'>
<link rel='stylesheet' href='./vendor/pure-release-0.6.0/pure-min.css'>
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

<?php if (Auth\User::isAuthorized()): ?>
<script src='./vendor/jquery-2.0.3.min.js'></script>
<script src='./vendor/jquery.json-1.3.js'></script>
<script src='./vendor/bootstrap/js/bootstrap.min.js'></script>
<script src='./js/ajax-form.js'></script>
<script src='./js/js_scripts.js'></script>		
	
    
	
</style>
<body>
";
	
	fwrite ( $file, $pattern );
	return $file;
}

function addContent ($file, $content) {
	fwrite ($file, $content);
}

function endCreateWebForm ($file) {
	$pattern = "
</body>
		
<?php else : header('Location: index.php'); ?>
<?php endif; ?>		
		
</html>
	";
	
	fwrite ( $file, $pattern );
	fclose ($file);
}



?>
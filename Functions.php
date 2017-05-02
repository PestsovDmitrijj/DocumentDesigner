<?php
function goToWebPage ($fileName) {
	header("Location:".$fileName);
}

function startCreateWebForm ($fileName) {
	$file = fopen( $fileName, "x" );
	
	$pattern = "<html>
	<head>
		<title>$fileName</title>
		<meta charset = 'utf-8'>
	</head>
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
		
</html>
	";
	
	fwrite ( $file, $pattern );
	fclose ($file);
}


?>
<?php
include 'Functions.php';


	
$fileName = "testRedactor.php";
$title = "Редактор веб-страниц";

if ( file_exists($fileName) ) {
	echo "<meta charset=utf-8><font size=5 color=red>Файл с таким именем уже существует!</font>";
} else {
	$file = startCreateWebForm($fileName);

	$content = "<font size='5' color='green'>
<center>Оно работает!</center>
</font>";
	addContent($file, $content);

	endCreateWebForm($file);
	goToWebPage ($fileName);
}


?>
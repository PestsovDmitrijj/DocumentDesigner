<?php
include 'Functions.php';

$fileName = $_POST['store_name'];
$title = "Редактор веб-страниц";
$hidd = $_POST['store_page'];

if ( file_exists($fileName) ) {
	echo "<meta charset=utf-8><font size=5 color=red>Файл с таким именем уже существует!</font>";
} else {
	$file = startCreateWebForm($fileName);

	$content = recuperation($hidd);
	addContent($file, $content);

	endCreateWebForm($file);
	goToWebPage ($fileName);
}


?>
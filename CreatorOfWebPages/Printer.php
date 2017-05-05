<?php
include 'Functions.php';

<<<<<<< HEAD
$fileName = $_POST['store_name'];
=======
<<<<<<< HEAD
/*
=======

>>>>>>> 902c4f9375d9f13da6d948893c8c1b7d96f81cb8
	
$fileName = "testRedactor.php";
>>>>>>> 877fec1c8a62ee55fe4bfc3a1928c155b4c5e467
$title = "Редактор веб-страниц";
$hidd = $_POST['store_page'];

if ( file_exists($fileName) ) {
	echo "<meta charset=utf-8><font size=5 color=red>Файл с таким именем уже существует!</font>";
} else {
	$file = startCreateWebForm($fileName);

	$content = recuperation($hidd);
	addContent($file, $content);
<<<<<<< HEAD
*/
	endCreateWebForm($file);
	goToWebPage ($fileName);
//}
=======

	endCreateWebForm($file);
	goToWebPage ($fileName);
}
>>>>>>> 902c4f9375d9f13da6d948893c8c1b7d96f81cb8


?>
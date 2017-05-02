<?php
include 'Functions.php';

<<<<<<< HEAD
/*
=======

>>>>>>> 902c4f9375d9f13da6d948893c8c1b7d96f81cb8
	
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
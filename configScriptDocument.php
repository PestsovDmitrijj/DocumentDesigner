<?php
//function header_call(){
//   header('Location:index.php');
//}
//header_call();
//===========================================
// * Подключение библиотеки и необходимых функций
//===========================================
include_once ('./classes/phpodt-0.3.3/phpodt.php');
include_once ('getData.php');
require 'funcs.php'; 
$fileName = $_POST['specialty']." ".$_POST['disc']." ".$date.".odt";
$fileName = rus2translit($fileName);
header("Location:".$fileName);
ini_set('display_errors',1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8, true');
//===========================================
// * За основу взята библиотека PHP-ODT (v0.3.3), 
// * модифицированная для создания этого
// * документа.
// *
// * LINK: http://php-odt.sourceforge.net/index.php;
// * AUTHOR: author Issam RACHDI;
//===========================================

//===========================================
// * Получаем специальность и дисциплину из веб-формы
//===========================================
$nameSpec = null;
$nameDisc = null;

if(isset($_POST['specialty'])){
	$nameSpec = $_POST['specialty'];
	//echo $nameSpec;
}
if(isset($_POST['disc'])){
	$nameDisc = $_POST['disc'];
	//echo $nameDisc;
}

//===========================================
// * Получаем кол-во тем и разделов из веб-формы
//===========================================

$razdCount = null;
//$temCount = null;
if(isset($_POST['razdCount'])){
	$razdCount = $_POST['razdCount'];
}
/*if(isset($_POST['temCount'])){
$temCount = $_POST['temCount'];}*/

//===========================================
// * Немножко дебуга
//===========================================

if (($nameSpec == null) || ($nameSpec == 0))  {
	echo '<p><font size="5" color="#FFA500" face="Arial">!</font>';
	echo "Не задана специальность: (Будет использовано 'Наименование специальности').</p>";
	$nameSpec = "Наименование специальности";
}

if (($nameDisc == null) || ($nameDisc === 0)) {
	//echo $nameDisc;
	echo '<p><font size="5" color="#FFA500" face="Arial">!</font>';
	echo "Не задана дисциплина: (Будет использовано 'Наименование дисциплины').</p>";
	$nameDisc = "Наименование дисциплины";
}

//===========================================

$odt = ODT::getInstance();

global $pageStyle;

//===========================================
// * Создание стилей страницы. 
// *
// * master1 -- альбомная страница
// * Standard -- базовый стиль, портретный
// *
// * Стиль, созданным последним, будет автоматически применён
// * ко всему документу
//===========================================

$pageStyle2 = new PageStyle('layout7', 'master1', StyleConstants::LANDSCAPE, 'master1');
$pageStyle1 = new PageStyle('layout1', 'Standard', StyleConstants::PORTRAIT, 'Standard');

//===========================================

//===========================================
// * Стили параграфов, необходимые для "переворачивания"
// * страницы из портретной в альбомную
//===========================================

$p1 = new ParagraphStyle('P1', 'Standard', 'master1');
$p3 = new ParagraphStyle('P3', 'master1', 'Standard');

//===========================================
// * Сами параграфы. Таким образом: чтобы страница стала 
// * альбомной, нужно в конце предыдущей страницы создать
// * параграф со стилем $p1t
//===========================================

$p1t = new TextStyle('P1');
$p3t = new TextStyle('P3');

// $p2t = new TextStyle('P2');       
// $p3t = new TextStyle('P3');       
// $p2->setBreakBefore(StyleConstants::PAGE);
$p1->setBreakBefore(StyleConstants::PAGE);
$p3->setBreakBefore(StyleConstants::PAGE);

//===========================================
// * Таблица для заголовка
//===========================================

$boldedText = new TextStyle('boldedText');          
$boldedText->setBold();          
$boldedText->setFontSize(11);       
//===========================================
// * Текст слева
//===========================================

$leftText = new ParagraphStyle('left', null, null);
$leftText->setTextAlign(StyleConstants::LEFT);
      

$centerText = new ParagraphStyle('centerText', null, null);
$centerText->setTextAlign(StyleConstants::CENTER);



//===========================================
// * Описание стилей, используемых в документе
//===========================================
// * Жирный текст
//===========================================

$bolded = new TextStyle('bolded');
$bolded->setBold();
$bolded->setFontSize(14);

//===========================================
// * 14 кегль
//===========================================

$frt = new TextStyle('frtText');   
$frt->setFontSize(14);    
           
//===========================================
// * Текст по центру
//===========================================

$centeredText = new ParagraphStyle('centered', null, null);
$centeredText->setTextAlign(StyleConstants::CENTER);

//===========================================
// * Текст слева
//===========================================

$leftText = new ParagraphStyle('left', null, null);
$leftText->setTextAlign(StyleConstants::LEFT);

//===========================================
// * Текст справа
//===========================================

$rightText = new ParagraphStyle('right', null, null);
$rightText->setTextAlign(StyleConstants::RIGHT);

//===========================================
//* Текст по ширине
//===========================================

$jstText = new ParagraphStyle('jstText', null, null);
$jstText->setTextAlign(StyleConstants::JUSTIFY);
$jstText->setTextIndent('1cm');

//===========================================
// KOSTYLIQUE
//===========================================

$jstText1 = new ParagraphStyle('Standard1', null, null);
$jstText1->setTextAlign(StyleConstants::JUSTIFY);
$jstText1->setTextIndent('1cm');

//===========================================
// * Разрыв страницы после текста
//===========================================

$withBreak = new ParagraphStyle('withBreak', null, null);
$withBreak->setTextAlign(StyleConstants::CENTER);
$withBreak->setBreakAfter(StyleConstants::PAGE);

//===========================================



?>
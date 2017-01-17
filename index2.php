<?php
//function header_call(){
//   header('Location:index.php');
//}
//header_call();
//===========================================
// * Подключение библиотеки и необходимых функций
//===========================================
include_once ('./classes/phpodt-0.3.3/phpodt.php');
include_once ('getData2.php');
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
// * Запросы из БД на выборку шаблонного текста
//===========================================

$title = select_all("Title2");
$ContStruct = select_all("ContStruct2");
$explanatoryNote = select_all("ExplanatoryNote2");
$MarkResults = select_all("MarkResults2");
$ApplicationTwo = select_all("ApplicationTwo");
$ApplicationThree = select_all("ApplicationThree2");
$ApplicationFour = select_all("ApplicationFour2");
$ApplicationFive = select_all("ApplicationFive2");
$ApplicationSix = select_all("ApplicationSix2");
$ProfComp = select_all("ProfComp");

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
// * Добавляем таблицы для верхнего колонтитула, 
// * немножко KOSTYL-edition
//===========================================
	
$pageStyle1->setHeaderContent($tableHeader);
$pageStyle2->setHeaderContent($tableHeader);

//===========================================


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



//===========================================
// * Page 1
// * Текст из БД, не меняется пользователем
//===========================================

$p = new Paragraph($centeredText);
$p->addText($title[0], $bolded);

$p = new Paragraph($centeredText);
$p->addText($title[1], $bolded);

$p = new Paragraph($centeredText);
$p->addText($title[2], $bolded);

$p = new Paragraph($centeredText);
$p->addText($title[3], $bolded);

addBlankLines(4);

$table = new Table('table1');
$tableStyle = new TableStyle($table->getTableName());
//$tableStyle->setWidth('100cm');
$table->setStyle($tableStyle);
$table->createColumns(2);
$columnStyle1 = $table->getColumnStyle(0);
//$columnStyle1->setWidth('10cm');
$columnStyle2 = $table->getColumnStyle(1);
//$columnStyle2->setWidth('100cm');

$str11 = new Paragraph($centeredText);
$str11->addText($title[4], $bolded);

$str21 = new Paragraph($centeredText);
$str21->addText($title[5], $bolded);

$str13 = new Paragraph($leftText);
$str13->addText($_POST['company'], $frt);

$str23 = new Paragraph($leftText);
$str23->addText($title[6], $frt);

$str14 = new Paragraph($leftText);
$str14->addText($_POST['position'], $frt);

$str25 = new Paragraph($leftText);
$str25->addText($title[7], $frt);

$str16 = new Paragraph($leftText);
$str16->addText("_________".$_POST['fio'], $frt);

$str27 = new Paragraph($leftText);
//$str27->addText("«___» ___________2015", $frt);
$str27->addText($title[8], $frt);

$str18 = new Paragraph($leftText);
$str18->addText($title[8], $frt);

$str29 = new Paragraph($leftText);
$str29->addText($title[10], $frt);

$rows = array(array($str11,$str21));
$table->addRows($rows, true, null, null);
$rows = array(array($str12,$str22));
$table->addRows($rows, true, null, null);
$rows = array(array($str13,$str23));
$table->addRows($rows, true, null, null);
$rows = array(array($str14));
$table->addRows($rows, true, null, null);
$rows = array(array( "",$str25));
$table->addRows($rows, true, null, null);
$rows = array(array($str16));
$table->addRows($rows, true, null, null);
$rows = array(array("",$str27));
$table->addRows($rows, true, null, null);
$rows = array(array($str18));
$table->addRows($rows, true, null, null);
$rows = array(array("",$str29));
$table->addRows($rows, true, null, null);
addBlankLines(4);

$p = new Paragraph($centeredText);
$p -> addText($title[11], $bolded);
$p = new Paragraph($centeredText);
$p -> addText($title[12], $bolded);
$p = new Paragraph($centeredText);
$p -> addText($title[13], $bolded);
$p = new Paragraph($centeredText);
$p -> addText($_POST['specialty'], $bolded);
$p = new Paragraph($centeredText);
$p -> addText(Training(0), $bolded);
$p = new Paragraph($centeredText);
$p -> addText($title[15], $bolded);
addBlankLines(3);

$table = new Table('table2');
$tableStyle = new TableStyle($table->getTableName());
//$tableStyle->setWidth('100cm');
$table->setStyle($tableStyle);
$table->createColumns(2);
$columnStyle1 = $table->getColumnStyle(0);
//$columnStyle1->setWidth('10cm');
$columnStyle2 = $table->getColumnStyle(1);
//$columnStyle2->setWidth('100cm');

$str = new Paragraph($leftText);
$str->addText($title[16], $bolded);
$rows = array(array("",$str));
$table->addRows($rows, true, null, null);
$str = new Paragraph($leftText);
$str->addText($title[17], $bolded);
$rows = array(array("",$str));
$table->addRows($rows, true, null, null);
$str = new Paragraph($leftText);
$str->addText("", $bolded);
$rows = array(array("",$str));
$table->addRows($rows, true, null, null);
$str->addText($title[18],$frt);
$rows = array(array("",$str));
$table->addRows($rows, true, null, null);
$str = new Paragraph($leftText);
$str->addText("", $bolded);
$rows = array(array("",$str));
$table->addRows($rows, true, null, null);
$str->addText($title[19],$frt);
$rows = array(array("",$str));
$table->addRows($rows, true, null, null);
addBlankLines(6);

$p = new Paragraph($centeredText);
$p->addText($title[20], $frt);
$p = new Paragraph($centeredText);
$p->addText($title[21], $frt);
$p = new Paragraph($withBreak);
$p->addText("", $bolded);

//===========================================
// * Page 2
//===========================================

$p = new Paragraph($jstText);
$p->addText($title[22], $frt);
$p = new Paragraph($centeredText);
$p->addText($_POST['specialty'], $frt);
addBlankLines(2);
$p = new Paragraph($jstText);
$p->addText($title[23], $frt);
addBlankLines(1);
$p = new Paragraph($leftText);
$p->addText("РАССМОТРЕНО", $frt);
addBlankLines(1);
$p = new Paragraph($leftText);
$p->addText($title[24], $frt);
addBlankLines(1);

$p = new Paragraph($leftText);
$p->addText("«".$_POST['specialty']."»", $frt);
addBlankLines(1);
$p = new Paragraph($leftText);
$p->addText($title[27], $frt);
addBlankLines(3);
$p = new Paragraph($leftText);
$p->addText($title[28], $frt);
$p = new Paragraph($leftText);
$p->addText("«".$_POST['specialty']."»", $frt);
addBlankLines(2);

$table = new Table('table3');
$tableStyle = new TableStyle($table->getTableName());
$tableStyle->setWidth('50cm');
$table->setStyle($tableStyle);
$table->createColumns(2);
$columnStyle2 = $table->getColumnStyle(1);
$columnStyle2->setWidth('40cm');
$columnStyle1 = $table->getColumnStyle(0);
$columnStyle1->setWidth('10cm');

$str11 = new Paragraph($leftText);
$str11->addText("___________", $frt);
$str21 = new Paragraph($leftText);
$str21->addText("________________", $frt);
$str12 = new Paragraph($leftText);
$str12->addText("Подпись", $frt);
$str22 = new Paragraph($leftText);
$str22->addText("Расшифровка подписи (А.В.Иванова)", $frt);
$rows = array(array($str11,$str21));
$table->addRows($rows, true, null, null);
$rows = array(array($str12,$str22));
$table->addRows($rows, true, null, null);

$p = new Paragraph($withBreak);
$p->addText("", $bolded);

//===========================================
// * PAGE 3
//===========================================

$p = new Paragraph($centeredText);
$p->addText("Пояснительная записка", $bolded);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[1], $frt);
$p -> addText(" ".$_POST['specialty']." ", $frt);
$p->addText(Training(1).".", $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[3], $frt);

$list = new ODTList(array());
for ($i = 4; $i < 9; $i++) {
	$p = new Paragraph($jstText, false);
	$p->addText($explanatoryNote[$i], $frt);
	$list->addItem($p);
}

$p = new Paragraph($jstText);
$p->addText($explanatoryNote[9], $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[10], $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[11], $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[12], $frt);
$p -> addText(" ".$_POST['specialty'].", ", $frt);
$p -> addText(" ".$_POST['explanatoryNote1']." от ", $frt);
$p -> addText($_POST['explanatoryNoteYear1']." года № ", $frt);
$p -> addText($_POST['explanatoryNoteNumber1'], $frt);
$p -> addText(" (зарегистрированный в Министерстве юстиции от ", $frt);
$p -> addText($_POST['explanatoryNoteYear2'], $frt);
$p -> addText(" года  № ", $frt);
$p -> addText($_POST['explanatoryNoteNumber2'], $frt);
$p -> addText(").", $frt);

$p = new Paragraph($jstText);
$p->addText($explanatoryNote[13], $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[14], $frt);

$p = new Paragraph($jstText);
$p->addText($explanatoryNote[15], $frt);
$p -> addText(" ".$_POST['specialty'], $frt);
$p->addText($explanatoryNote[16], $frt);

$p = new Paragraph($jstText);
$p->addText($explanatoryNote[17], $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[18], $frt);
$p = new Paragraph($jstText);

//===========================================
// * PAGE 4
//===========================================

$p->addText($explanatoryNote[19], $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[20], $frt);
$p -> addText(" ".$_POST['specialty'].".", $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[21], $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[22], $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[23], $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[24], $frt);
$p -> addText(" ".$_POST['specialty']." ", $frt);
$p->addText($explanatoryNote[25], $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[26], $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[27], $frt);
$p -> addText(" с ".$_POST['trainingVKR-S']." ", $frt);
$p -> addText(" по ".$_POST['trainingVKR-PO'].";", $frt);
$p = new Paragraph($jstText);
$p->addText($explanatoryNote[28], $frt);
$p -> addText(" с ".$_POST['protectionVKR-S']." ", $frt);
$p -> addText(" по ".$_POST['protectionVKR-PO'].".", $frt);

//===========================================
// * СОДЕРЖАНИЕ И СТРУКТУРА ГОСУДАРСТВЕННОЙ ИТОГОВОЙ АТТЕСТАЦИИ
//===========================================

addBlankLines(1); 
$p = new Paragraph($centeredText);
$p->addText("1 ".$ContStruct[0], $bolded);
$p = new Paragraph($centeredText);
$p->addText($ContStruct[1], $bolded);
addBlankLines(1); 
$p = new Paragraph($leftText);
$p->addText($ContStruct[2], $bolded);
$p = new Paragraph($jstText);
$p->addText($ContStruct[3], $frt);
$p -> addText(" ".$_POST['date']." ", $frt);
$p->addText($ContStruct[4], $frt);
$p -> addText(" ".$_POST['specialty']." ", $frt);
$p->addText($ContStruct[5], $frt);
$p -> addText(" ".Training(1)." ", $frt);
$p->addText($ContStruct[6], $frt);

Print_Paragraph( 7, 14, $ContStruct, $jstText, $frt );

$p = new Paragraph($jstText);
$p->addText("1. ".$_POST['activityOne'].";", $frt);

$p = new Paragraph($jstText);
$p->addText("2. ".$_POST['activityTwo'].";", $frt);

$p = new Paragraph($jstText);
$p->addText($ContStruct[15], $frt);
$p->addText(" «".$_POST['profession']."»:", $frt);

$list = new ODTList(array());
for ($i = 0; $i <= $_POST['countEqTso']; $i++) {
	if (isset($_POST['tso'.$i]) && $_POST['tso'.$i] != '') {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['tso'.$i].";", $frt);
		$list->addItem($p);
	} 
}

$p = new Paragraph($jstText);
$p->addText("4. ".$_POST['fourPoint'], $frt);
$p = new Paragraph($jstText);
$p->addText($ContStruct[17], $frt);


$p = new Paragraph($jstText);
$p->addText($ContStruct[18], $frt);
$p->addText("  ".$_POST['activityOne'].":", $frt);

$counter = 0;
while ( $counter <= 9 ){
	$p = new Paragraph($jstText);
	$p->addText("ПК 1.".($counter+1)." ", $frt);
	$p->addText($ProfComp[$counter], $frt);
	$counter++;
}
// for ($i = 1; ; $i++) {
	// if (isset($_POST['PC'.$i])) {
		// $p = new Paragraph($jstText);
		// $p->addText($_POST['PC'.$i], $frt);
	// } else {
		// break;
	// }
// } 


$p = new Paragraph($jstText);
$p->addText($ContStruct[19], $frt);
$p->addText("  ".$_POST['activityTwo'].":", $frt);

$counter = 10;
$numberComp = 1;
while ( $counter <= 15 ){
	$p = new Paragraph($jstText);
	$p->addText("ПК 2.".($numberComp)." ", $frt);
	$p->addText($ProfComp[$counter], $frt);
	$counter++;
	$numberComp++;
}

$p = new Paragraph($jstText);
$p->addText($ContStruct[20], $frt);
$p->addText(" «".$_POST['profession']."»:", $frt);

for ($i = 0; $i <= $_POST['countEqTso']; $i++) {
	if (isset($_POST['tso'.$i]) && $_POST['tso'.$i] != '') {
		$p = new Paragraph($jstText);
		$p->addText("- ".$_POST['tso'.$i].";", $frt);
	} 
}

for ($i = 0; $i <= $_POST['countEqLab']; $i++) {
	if (isset($_POST['eqLab'.$i]) && $_POST['eqLab'.$i] != '') {
		$p = new Paragraph($jstText);
		$p->addText($_POST['eqLab'.$i].";", $frt);
	} 
}

$p = new Paragraph($jstText);
$p->addText("4. ".$_POST['fourPoint'], $frt);

for ($i = 0; $i <= $_POST['countDLit']; $i++) {
	if (isset($_POST['dLit'.$i])) {
		$p = new Paragraph($jstText);
		$p->addText($_POST['dLit'.$i].";", $frt);
	} 
}

Print_Paragraph( 21, 24, $ContStruct, $jstText, $frt );

$p = new Paragraph($jstText);
$p->addText($ContStruct[25], $frt);
$p -> addText(" «".$_POST['specialty']."».", $frt);

Print_Paragraph( 26, 27, $ContStruct, $jstText, $frt );
Print_Paragraph( 28, 28, $ContStruct, $jstText, $bolded );
Print_Paragraph( 29, 48, $ContStruct, $jstText, $frt );
Print_Paragraph( 49, 49, $ContStruct, $jstText, $bolded );
Print_Paragraph( 50, 62, $ContStruct, $jstText, $frt );

$p = new Paragraph($jstText);
$p->addText($ContStruct[63], $frt);
$p -> addText(" «".$_POST['specialty']."» ", $frt);
$p->addText($ContStruct[64], $frt);

Print_Paragraph( 65, 65, $ContStruct, $jstText, $bolded );

$p = new Paragraph($jstText);
$p->addText($ContStruct[66], $frt);
$p -> addText(" ".$_POST['specialty']." ", $frt);
$p->addText($ContStruct[67], $frt);

Print_Paragraph( 68, 70, $ContStruct, $jstText, $frt );
Print_Paragraph( 71, 71, $ContStruct, $jstText, $bolded );
Print_Paragraph( 72, 72, $ContStruct, $jstText, $frt );

$p = new Paragraph($jstText);
$p->addText($ContStruct[73], $frt);
$p->addText(" ".$ContStruct[74], $frt);

Print_Paragraph( 75, 75, $ContStruct, $jstText, $frt );

$p = new Paragraph($jstText);
$p->addText($ContStruct[76], $frt);
$p->addText(" «".$_POST['Name_PCK']."» ", $frt);
$p->addText(" ".$ContStruct[77], $frt);

Print_Paragraph( 78, 78, $ContStruct, $jstText, $frt );

$p = new Paragraph($jstText);
$p->addText($ContStruct[79], $frt);
$p->addText(" ".$ContStruct[80], $frt);

Print_Paragraph( 81, 84, $ContStruct, $jstText, $frt );

$p = new Paragraph($jstText);
$p->addText($ContStruct[85], $frt);
$p->addText(" «".$_POST['Name_Qualification']."» ", $frt);
$p->addText(" ".$ContStruct[86], $frt);

Print_Paragraph( 87, 88, $ContStruct, $jstText, $frt );

$p = new Paragraph($jstText);
$p->addText($ContStruct[89], $frt);
$p->addText(" ".$ContStruct[90], $frt);

Print_Paragraph( 91, 91, $ContStruct, $jstText, $frt );

Print_Paragraph( 92, 92, $ContStruct, $jstText, $bolded );

$p = new Paragraph($jstText);
$p->addText($ContStruct[93], $frt);
$p->addText(" ".$ContStruct[94], $frt);

Print_Paragraph( 95, 96, $ContStruct, $jstText, $frt );

//===========================================
// * ОЦЕНКА РЕЗУЛЬТАТОВ ГОСУДАРСТВЕННОЙ ИТОГОВОЙ АТТЕСТАЦИИ
//===========================================

Print_Paragraph( 0, 0, $MarkResults, $jstText, $bolded );
Print_Paragraph( 1, 1, $MarkResults, $jstText, $frt );

$p = new Paragraph($jstText);
$p->addText($MarkResults[2], $frt);
$p->addText(" ".$_POST['Name_Project']." ", $frt);
$p->addText($MarkResults[3], $frt);
$p->addText(" ".$_POST['Name_Project']." ", $frt);
$p->addText($MarkResults[4], $frt);

Print_Paragraph( 5, 15, $MarkResults, $jstText, $frt );

$p = new Paragraph($jstText);
$p->addText($MarkResults[16], $frt);
$p->addText(" ".$_POST['Name_Project']." ", $frt);
$p->addText($MarkResults[17], $frt);

Print_Paragraph( 18, 31, $MarkResults, $jstText, $frt );




// до приложений







$date = date("d-m-y");
//$fileName = $_POST['specialty']." ".$_POST['disc']." ".$date.".odt";
//$fileName = rus2translit($fileName);

$odt->output($fileName);
//header("Location:".$fileName);

?>

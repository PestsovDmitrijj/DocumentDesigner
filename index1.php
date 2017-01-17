<?php
//function header_call(){
//   header('Location:index.php');
//}
//header_call();
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
// * Подключение библиотеки и необходимых функций
//===========================================

include_once ('./classes/phpodt-0.3.3/phpodt.php');
include_once ('getData.php');
require 'funcs.php'; 


//===========================================
// * Получаем специальность и дисциплину из веб-формы
//===========================================
$nameSpec = null;
$nameDisc = null;


//Функция трансляции
function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}
function str2url($str) {
    // переводим в транслит
    $str = rus2translit($str);
    // в нижний регистр
    $str = strtolower($str);
    // заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    // удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
}

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

$title = getTitleData();
$content = getContentData();
$subHeads = getSubHeadsData();
$docContent = getDocContentData();

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
// * Неизменяемая информация
//===========================================
	
$p00 = new Paragraph($centerText, false);
$p00->addText('Государственное бюджетное профессиональное 
образовательное учреждение  «Нижегородский 
радиотехнический колледж» (ГБПОУ «НРТК»)', $boldedText);
$p10 = new Paragraph($centerText, false);
$p10->addText('Рабочая программа учебной дисциплины');
$p11 = new Paragraph($centerText, false);
$p11->addText("Дата разработки ".$_POST['dateCreate']);
$p12 = new Paragraph($leftText, false);
$p12->addText('Лист ');
$pageNumber = ODT::getInstance()->getDocumentContent()->createElement('text:page-number');
$pageNumber->setAttribute('text:select-page', 'current');
$p12->getDOMElement()->appendChild($pageNumber);

//===========================================
// * Изменяемая информация
//===========================================

$p21 = new Paragraph($centerText, false);
$p21->addText($nameDisc, false);
$p22 = new Paragraph($centerText, false);
$p22->addText("Изменение №  ".$_POST['numChange']);
$p23 = new Paragraph($leftText, false);
$p23->addText("Страниц из ");
$pageCount = ODT::getInstance()->getDocumentContent()->createElement('text:page-count');
$p23->getDOMElement()->appendChild($pageCount);

$tableHeader = new table('tableHeader1', null, false);
$tableHeaderStyle = new tableStyle($tableHeader->getTableName());
$tableHeader->setStyle($tableHeaderStyle);
$tableHeaderStyle->setWidth('12cm');
$tableHeader->setStyle($tableHeaderStyle);
$tableHeader->createColumns(1);
$rows = array(array($p00));
$tableHeader->addRows($rows, true, null, null);
$tableHeader->createColumns(2);
$rows = array(array($p10, $p11, $p12),array($p21, $p22, $p23));
$tableHeader->addRows($rows, true, null, null);
	
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

addBlankLines(20);

//===========================================
// * Page 1
// * Текст из БД, не меняется пользователем
//===========================================

$p = new Paragraph($centeredText);
$p->addText($title[0], $bolded);

//===========================================
// * Наименование дисциплины, из Веб-формы
//===========================================

$p = new Paragraph($centeredText);
$p->addText($nameDisc, $frt);

//===========================================
// * Текст из БД, не меняется пользователем
//===========================================

$p = new Paragraph($centeredText);
$p->addText($title[1], $bolded);

//===========================================
// * Наименование специальности, из Веб-формы
//===========================================

$p = new Paragraph($centeredText);
$p->addText($nameSpec, $frt);

//===========================================
// * (базовая подготовка)
//===========================================

$p = new Paragraph($centeredText);
$p->addText($title[2], $bolded);

addBlankLines(15);

//===========================================
// * Город, год
//===========================================

$p = new Paragraph($centeredText);
$p->addText($title[3], $bolded);

$p = new Paragraph($withBreak);
$p->addText(date("Y")." г.", $bolded);

//===========================================
// * PAGE 2
//===========================================

addBlankLines(1);

$p = new Paragraph($jstText);
$p->addText($title[5], $frt);
$p->addText(" «".$nameSpec."».", $frt);


addBlankLines(4);
$p = new Paragraph($jstText);
$p->addText($title[7], $frt);
addBlankLines(4);
$p = new Paragraph($jstText);
$p->addText($title[8]." «".$nameSpec."».", $frt);

$p = new Paragraph($jstText);
$p->addText($title[9], $frt);

$p = new Paragraph($jstText);
$p->addText($title[10], $frt);

addBlankLines(2);
$p = new Paragraph($jstText);
$p->addText($title[11], $frt);

$p = new Paragraph($jstText);
$p->addText($title[12], $frt);


$p = new Paragraph($withBreak);
$p->addText("", $bolded);

//===========================================
// * PAGE 3
//===========================================

//===========================================
// * Таблица с содержанием
// * TODO автоматическое содержание
//===========================================

addBlankLines(2);
$p = new Paragraph($centeredText);
$p->addText("СОДЕРЖАНИЕ", $bolded);
addBlankLines(2);
$table = new Table('table2');
$tableStyle = new TableStyle($table->getTableName());
$tableStyle->setWidth('50cm');
$table->setStyle($tableStyle);
$table->createColumns(2);
$columnStyle1 = $table->getColumnStyle(0);
$columnStyle1->setWidth('40cm');
$columnStyle2 = $table->getColumnStyle(1);
$columnStyle2->setWidth('10cm');
$str = new Paragraph($centeredText);
$str->addText("стр.");
$rows = array(array("", $str));
$table->addRows($rows, true, null, null);
$p1 = new Paragraph($jstText);
$p1->addText("1. ".$content[0], $bolded);
$pPage1 = new Paragraph($centeredText);
$pPage1->addText("4");
$p2 = new Paragraph($jstText);
$p2->addText("2. ".$content[1], $bolded);
$pPage2 = new Paragraph($centeredText);
$pPage2->addText("");
$p3 = new Paragraph($jstText);
$p3->addText("3. ".$content[2], $bolded);
$pPage3 = new Paragraph($centeredText);
$pPage3->addText("");
$p4 = new Paragraph($jstText);
$p4->addText("4. ".$content[3], $bolded);
$pPage4 = new Paragraph($centeredText);
$pPage4->addText("");
$rows = array(array($p1, $pPage1));
$table->addRows($rows, true, null, null);
$rows = array(array($p2, $pPage2));
$table->addRows($rows, true, null, null);
$rows = array(array($p3, $pPage3));
$table->addRows($rows, true, null, null);
$rows = array(array($p4, $pPage4));
$table->addRows($rows, true, null, null);

$p = new Paragraph($withBreak);
$p->addText("", $bolded);

//===========================================
// * PAGE 4
//===========================================

addBlankLines(2);

$p = new Paragraph($centeredText);
$p->addText("1.". $content[0], $bolded);
$p = new Paragraph($centeredText);
$p->addText("«".$nameDisc."»", $frt);

addBlankLines(2);

$p = new Paragraph($centeredText);
$p->addText("1.1. ".$subHeads[0], $bolded);

addBlankLines(2);

$p = new Paragraph($jstText);
$p->addText($docContent[0], $frt);


$p = new Paragraph($jstText);
$p->addText("Рабочая программа учебной дисциплины может быть использована", $frt);

$p = new Paragraph($centeredText);
$p->addText("1.2. ".$subHeads[1], $bolded);

$p = new Paragraph($centeredText);
$p->addText("1.3. ".$subHeads[2], $bolded);

$p = new Paragraph($jstText);
$p->addText($docContent[1], $frt);

$list = new ODTList(array());
for ($i = 1; ; $i++) {
	if (isset($_POST['Skill'.$i])) {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['Skill'.$i], $frt);
		$list->addItem($p);
	} else {
		break;
	}
}

addBlankLines(1);

$p = new Paragraph($jstText);
$p->addText($docContent[2], $frt);

$list = new ODTList(array());
for ($i = 1; ; $i++) {
	if (isset($_POST['Knowledge'.$i])) {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['Knowledge'.$i], $frt);
		$list->addItem($p);
	} else {
		break;
	}
}

$dummy = new Paragraph($withBreak);
$dummy->addText("");

 // $pTest1 = new Paragraph($p1t);
 // $pTest1->addText("");

//===========================================
// * PAGE 5
//===========================================


addBlankLines(2);


$p = new Paragraph($jstText);
$p->addText($docContent[3], $frt);

/* addBlankLines(2);
$table = new Table('tablePC');
$tableStyle = new TableStyle($table->getTableName());
$tableStyle->setWidth('50cm');
$table->setStyle($tableStyle);
$table->createColumns(2);
$columnStyle1 = $table->getColumnStyle(0);
$columnStyle1->setWidth('10cm');
$columnStyle2 = $table->getColumnStyle(1);
$columnStyle2->setWidth('40cm');
$nro = new Paragraph($centeredText);
$nro->addText("Наименование результата обучения");
$code = new Paragraph($centeredText);
$code->addText("Код");
$rows = array(array($code, $nro));
$table->addRows($rows, true, null, null); */


//getPCParagraph($nameDisc, $nameSpec);

for ($i = 1; ; $i++) {
	if (isset($_POST['PC'.$i])) {
		$p = new Paragraph($jstText);
		$p->addText($_POST['PC'.$i], $frt);
	} else {
		break;
	}
} 
addBlankLines(1);
$p = new Paragraph($jstText);
$p->addText($docContent[4], $frt);

//getGCParagraph($nameDisc, $nameSpec);

 for ($i = 1; ; $i++) {
	if (isset($_POST['GC'.$i])) {
		$p = new Paragraph($jstText);
		$p->addText($_POST['GC'.$i], $frt);
	} else {
		break;
	}
} 

addBlankLines(1);

/* $p = new Paragraph($centeredText);
$p->addText("1.4. ".$subHeads[3], $bolded); */

// TODO

$p = new Paragraph($centeredText);
$p->addText("1.5. Количество часов по учебному плану на освоение рабочей программы дисциплины:", $bolded);


$p = new Paragraph($jstText);
$p->addText("максимальной учебной нагрузки обучающегося ", $frt);
$p->addText($_POST['sumAll']."ч.", $frt);
$p->addText(", в том числе: ", $frt);

$p = new Paragraph($jstText);
$sumOb = 0;
if (isset($_POST['sumPrakt'])) {
	$sumOb += $_POST['sumPrakt'];
}
if (isset($_POST['sumLabor'])) {
	$sumOb += $_POST['sumLabor'];
}
if (isset($_POST['sumSod'])) {
	$sumOb += $_POST['sumSod'];
}
$p->addText("обязательной аудиторной учебной нагрузки обучающегося ".$sumOb."ч.;", $frt);
$p = new Paragraph($jstText);

$p->addText("самостоятельной работы обучающегося ".($_POST['sumSamPrakt']+$_POST['sumSamTeor'])."ч.;", $frt);
$dummy = new Paragraph($withBreak);
$dummy->addText("");


//===========================================
// * PAGE 6
//===========================================


addBlankLines(2);

$p = new Paragraph($centeredText);
$p->addText("2. ".$content[1], $bolded);
$p = new Paragraph($centeredText);
$p->addText("«".$nameDisc."»", $frt);

addBlankLines(2);

$p = new Paragraph($centeredText);
$p->addText("2.1 ".$subHeads[4], $bolded);

addBlankLines(2);

$table = new Table('table3');
$tableStyle = new TableStyle($table->getTableName());
$tableStyle->setWidth('50cm');
$table->setStyle($tableStyle);
$table->createColumns(2);
$columnStyle1 = $table->getColumnStyle(0);
$columnStyle1->setWidth('40cm');
$columnStyle2 = $table->getColumnStyle(1);
$columnStyle2->setWidth('10cm');

$str = new Paragraph($centeredText);
$str->addText("Вид учебной работы", $bolded);
$str1 = new Paragraph($centeredText);
$str1->addText("Объем часов", $bolded);
$rows = array(array($str, $str1));
$table->addRows($rows, true, null, null);


$str = new Paragraph($centeredText);
$str->addText("Максимальная учебная нагрузка (всего)", $bolded);
$str1 = new Paragraph($centeredText);
$str1->addText($_POST['sumAll'], $bolded);
$rows = array(array($str, $str1));
$table->addRows($rows, true, null, null);

$str = new Paragraph($jstText);
$str->addText("в том числе:", $frt);
$str1 = new Paragraph($centeredText);
$str1->addText("", $bolded);
$rows = array(array($str, $str1));
$table->addRows($rows, true, null, null);

if (isset($_POST['contSod1Tem1Razd1'])) {
	$str = new Paragraph($jstText);
	$str->addText("лекции", $frt);
	$str1 = new Paragraph($centeredText);
	$str1->addText($_POST['sumSod'], $bolded);
	$rows = array(array($str, $str1));
	$table->addRows($rows, true, null, null);
}

if (isset($_POST['contPrakt1Tem1Razd1'])) {
	$str = new Paragraph($jstText);
	$str->addText("практические занятия", $frt);
	$str1 = new Paragraph($centeredText);
	$str1->addText($_POST['sumPrakt'], $bolded);
	$rows = array(array($str, $str1));
	$table->addRows($rows, true, null, null);
}

if (isset($_POST['contLabor1Tem1Razd1'])) {
	$str = new Paragraph($jstText);
	$str->addText("лабораторные работы", $frt);
	$str1 = new Paragraph($centeredText);
	$str1->addText($_POST['sumLabor'], $bolded);
	$rows = array(array($str, $str1));
	$table->addRows($rows, true, null, null);
}

/* 
$str = new Paragraph($jstText);
$str->addText("практические работы", $frt);
$str1 = new Paragraph($centeredText);
$str1->addText("*", $bolded);
$rows = array(array($str, $str1));
$table->addRows($rows, true, null, null); */


/* 
$str = new Paragraph($jstText);
$str->addText("курсовая работа", $frt);
$str1 = new Paragraph($centeredText);
$str1->addText("*", $bolded);
$rows = array(array($str, $str1));
$table->addRows($rows, true, null, null); */

$str = new Paragraph($jstText);
$str->addText("Самостоятельная работа обучающегося (всего)", $bolded);
$str1 = new Paragraph($centeredText);
$str1->addText(($_POST['sumSamPrakt']+$_POST['sumSamTeor']), $bolded);
$rows = array(array($str, $str1));
$table->addRows($rows, true, null, null);

$str = new Paragraph($jstText);
$str->addText("в том числе:", $frt);
$str1 = new Paragraph($centeredText);
$str1->addText("", $bolded);
$rows = array(array($str, $str1));
$table->addRows($rows, true, null, null);

if (isset($_POST['contSamPrakt1Tem1Razd1'])) {
	$str = new Paragraph($jstText);
	$str->addText("самостоятельные работы для практической части", $frt);
	$str1 = new Paragraph($centeredText);
	$str1->addText($_POST['sumSamPrakt'], $bolded);
	$rows = array(array($str, $str1));
	$table->addRows($rows, true, null, null);
}

if (isset($_POST['contSamTeor1Tem1Razd1'])) {
	$str = new Paragraph($jstText);
	$str->addText("самостоятельные работы для теоретической части", $frt);
	$str1 = new Paragraph($centeredText);
	$str1->addText($_POST['sumSamTeor'], $bolded);
	$rows = array(array($str, $str1));
	$table->addRows($rows, true, null, null);
}
// TODO итоговая аттестация
$att = $_POST['attestation'];
$str = new Paragraph($jstText);
$str->addText("Итоговая аттестация в форме ".$att, $frt);

if (isset($_POST['attestation2'])) {
	$str->addText(" ".$_POST['attestation2'], $frt);
}

$rows = array(array($str));
$table->addRows($rows, true, null, null);

  // $dummy = new Paragraph($withBreak);
  // $dummy->addText("");
  // $pTest = new Paragraph($p1t);
  // $pTest->addText("");
  
    

//===========================================
// * PAGE 7
//===========================================

addBlankLines(2);

//===========================================
// * Делаем страницу альбомной
//===========================================

$pTest1 = new Paragraph($p1t);
$pTest1->addText("");
 
//===========================================
// * Таблица тематического плана  и содержания 
// * учебной дисциплины
//===========================================

//===========================================
// * Заголовок
//===========================================

$p = new Paragraph($centeredText);
$p->addText("2.2. ".$subHeads[5]." «".$nameDisc."»", $bolded);

//===========================================
// * Начало таблицы
//===========================================

$table = new Table('table4');
$tableStyle = new TableStyle($table->getTableName());
$tableStyle->setWidth('50cm');
$table->setStyle($tableStyle);
$table->createColumns(4);
$columnStyle1 = $table->getColumnStyle(0);
$columnStyle1->setWidth('10cm');
$columnStyle2 = $table->getColumnStyle(1);
$columnStyle2->setWidth('25cm');
$columnStyle1 = $table->getColumnStyle(2);
$columnStyle1->setWidth('5cm');
$columnStyle2 = $table->getColumnStyle(3);
$columnStyle2->setWidth('5cm');

//===========================================
// * Заголовки таблицы
//===========================================

$str = new Paragraph($centeredText);
$str->addText("Наименование разделов и тем", $bolded);
$str1 = new Paragraph($centeredText);
$str1->addText("Содержание учебного материала, лабораторные  работы и практические занятия, самостоятельная работа обучающихся, курсовая работа (проект)", $bolded);
$str2 = new Paragraph($centeredText);
$str2->addText("Объем часов", $bolded);
$str3 = new Paragraph($centeredText);
$str3->addText("Уровень освоения", $bolded);
$rows = array(array($str, $str1, $str2, $str3));
$table->addRows($rows, true, null, null);

$str = new Paragraph($centeredText);
$str->addText("1", $bolded);
$str1 = new Paragraph($centeredText);
$str1->addText("2", $bolded);
$str2 = new Paragraph($centeredText);
$str2->addText("3", $bolded);
$str3 = new Paragraph($centeredText);
$str3->addText("4", $bolded);
$rows = array(array($str, $str1, $str2, $str3));
$table->addRows($rows, true, null, null);

//===========================================
// * Формирование таблицы из данных, полученных из веб-формы
//===========================================

//===========================================
// * Создание разделов
//===========================================

for ($i = 1; $i < $razdCount+1; $i++) {
	$razd = new Paragraph($centeredText);
	$razd->addText("Раздел ".$i.".", $bolded);
	$razdName = new Paragraph($centeredText);
	$razdName->addText($_POST["nameRazd".$i], $bolded);
	$razdHour = new Paragraph($centeredText);
	$razdHour->addText($_POST["hourRazd".$i]);
	$rows = array(array($razd, $razdName, $razdHour, ''));
	$table->addRows($rows, true, null, null);
	$n=1;
	
//===========================================
// * Для каждого раздела записываем темы
//===========================================
	
	
	//===========================================
	// * Считает количество строк в каждой теме, нужно для
	// * объединения ячеек
	//===========================================
	for ($j = 1; $j <= $_POST['maxNumRow']; $j++) {
		$countSod = 0;
		$countPrakt = 0;
		$countLabor = 0;
		$countSamPrakt = 0;
		$countSamTeor = 0;
		$temSum = 0;
		if (isset($_POST["nameTem".$j."Razd".$i])){
			for ($s = 1; $s <= $_POST['maxNumRow']; $s++)  {
				if (isset($_POST["contSod".$s."Tem".$j."Razd".$i])) {
					$countSod++;
				} 
			}
			for ($s = 1; $s <= $_POST['maxNumRow']; $s++)  {
				if (isset($_POST["contLabor".$s."Tem".$j."Razd".$i])) {
					$countLabor++;
				} 
			}
			for ($s = 1; $s <= $_POST['maxNumRow']; $s++)  {
				if (isset($_POST["contPrakt".$s."Tem".$j."Razd".$i])) {
					$countPrakt++;
				} 
			}
			for ($s = 1; $s <= $_POST['maxNumRow']; $s++)  {
				if (isset($_POST["contSamPrakt".$s."Tem".$j."Razd".$i])) {
					$countSamPrakt++;
				} 
			}
			for ($s = 1; $s <= $_POST['maxNumRow']; $s++)  {
				if (isset($_POST["contSamTeor".$s."Tem".$j."Razd".$i])) {
					$countSamTeor++;
				} 
			}
			
			$temSum += $countLabor + $countPrakt + $countSamPrakt + $countSamTeor + $countSod;
			if ($countLabor != 0) {
				$temSum++;
			}
			if ($countPrakt != 0) {
				$temSum++;
			}
			if (($countSamPrakt != 0) && ($countSamTeor != 0)) {
				$temSum++;
			} else if ($countSamTeor != 0) {
				$temSum++;
			} else if ($countSamPrakt != 0) {
				$temSum++;
			}
			if ($countSod != 0) {
				$temSum++;
			}

			//===========================================
			// * Название темы
			//===========================================
				$tem = new Paragraph($centeredText);
				$tem->addText("Тема ".$i.".".$n.". ".$_POST["nameTem".$j."Razd".$i], $bolded);
				$n++;
			//===========================================
			// * Количество часов
			//===========================================
				$temHour = new Paragraph($centeredText);
				$temHour->addText($_POST["hoursTem".$j."Razd".$i]);
				$rows = array(array($tem, 'Содержание учебного материала', $temHour, ''));
				$table->addRows($rows, true, 0, $temSum);
				
			//===========================================
			// * Записываем содержание учебного материала
			//===========================================
			$localNum = 1;
				for ($k = 1; $k <= $_POST['maxNumRow']; $k++) {
					if (isset($_POST["contSod".$k."Tem".$j."Razd".$i])){
						$contSod = new Paragraph($leftText);
						$contSod->addText("	".$localNum.".	".$_POST["contSod".$k."Tem".$j."Razd".$i]);
						$hoursSod = new Paragraph($centeredText);
						$hoursSod->addText($_POST["hoursSod".$k."Tem".$j."Razd".$i]);
						$lvlSod = new Paragraph($centeredText);
						$lvlSod->addText($_POST["lvlSod".$k."Tem".$j."Razd".$i]);
						$rows = array(array($contSod, $hoursSod, $lvlSod));
						$table->addRows($rows, true, null, null);
						$localNum++;
					} 
				}
				$localNum = 1;
			//===========================================
			// * Если есть практические работы, записываем их в таблицу
			//===========================================
			$countPrakt = 1;
				for ($k = 1; $k <= $_POST['maxNumRow']; $k++) {
					if (isset($_POST["contPrakt".$k."Tem".$j."Razd".$i])){
						$countPrakt++;
					} 
				}
				if (isset($_POST["contPrakt1Tem".$j."Razd".$i])){
					$hoursPrakt = new Paragraph($centeredText);
					$hoursPrakt->addText($_POST["hoursPraktTem".$j."Razd".$i]);
					$rows = array(array('Практические работы: ', $hoursPrakt, ));
					$table->addRows($rows, false, 1, $countPrakt);
				}
				
				for ($k = 1; $k <= $_POST['maxNumRow']; $k++) {
					if (isset($_POST["contPrakt".$k."Tem".$j."Razd".$i])){
						$contPrakt = new Paragraph($leftText);
						$contPrakt->addText("	".$localNum.".	".$_POST["contPrakt".$k."Tem".$j."Razd".$i]);
						$rows = array(array($contPrakt, '', ''));
						$table->addRows($rows, true, null, null);
						$localNum++;
					} 
				}
				
			//===========================================
			// * Если есть лабораторные работы, записываем их в таблицу
			//===========================================
			$countLabor = 1;
			$localNum = 1;
				for ($k = 1; $k <= $_POST['maxNumRow']; $k++) {
					if (isset($_POST["contLabor".$k."Tem".$j."Razd".$i])){
						$countLabor++;
					} 
				}
			
				if (isset($_POST["contLabor1Tem".$j."Razd".$i])){
					$hoursLabor = new Paragraph($centeredText);
					$hoursLabor->addText($_POST["hoursLaborTem".$j."Razd".$i]);
					$rows = array(array('Лабораторные работы: ', $hoursLabor, ));
					$table->addRows($rows, true, 1, $countLabor);
				}
				
				for ($k = 1; $k <= $_POST['maxNumRow']; $k++) {
					if (isset($_POST["contLabor".$k."Tem".$j."Razd".$i])){
						$contLabor = new Paragraph($leftText);
						$contLabor->addText("	".$localNum.".	".$_POST["contLabor".$k."Tem".$j."Razd".$i]);
						$rows = array(array($contLabor, '', ''));
						$table->addRows($rows, true, null, null);
						$localNum++;
					} 
				}
				
			//===========================================
			// * Если есть самостоятельные работы, записываем их в таблицу
			//===========================================
				$headerSam = false;

				if (isset($_POST["contSamPrakt1Tem".$j."Razd".$i])){
					$rows = array(array('Самостоятельные работы обучающихся: ', '', ''));
					$table->addRows($rows, true, null, null);
					$headerSam = true;
				}
				for ($k = 1; $k <= $_POST['maxNumRow']; $k++) {
					if (isset($_POST["contSamPrakt".$k."Tem".$j."Razd".$i])){
						$contSam = new Paragraph($leftText);
						$contSam->addText($_POST["contSamPrakt".$k."Tem".$j."Razd".$i]);
						$hoursSam = new Paragraph($centeredText);
						$hoursSam->addText($_POST["hoursSamPrakt".$k."Tem".$j."Razd".$i]);
						$rows = array(array($contSam, $hoursSam, ''));
						$table->addRows($rows, true, null, null);
					} 
				}
				
			//===========================================
			// * Если есть самостоятельные работы, записываем их в таблицу
			//===========================================
				if (isset($_POST["contSamTeor1Tem".$j."Razd".$i]) && $headerSam != true){
					$rows = array(array('Самостоятельные работы обучающихся: ', '', ''));
					$table->addRows($rows, true, null, null);
				}
				
				for ($k = 1; $k <= $_POST['maxNumRow']; $k++) {
					if (isset($_POST["contSamTeor".$k."Tem".$j."Razd".$i])){
						$contSam = new Paragraph($leftText);
						$contSam->addText($_POST["contSamTeor".$k."Tem".$j."Razd".$i]);
						$hoursSam = new Paragraph($centeredText);
						$hoursSam->addText($_POST["hoursSamTeor".$k."Tem".$j."Razd".$i]);
						$rows = array(array($contSam, $hoursSam, ''));
						$table->addRows($rows, true, null, null);
					} 
				}
		} else {
			break;
		}
	}
} 
//===========================================
// * Вывод общего количества часов
//===========================================
$sumAll = new Paragraph($rightText);
$sumAll->addText('Всего часов: ');
$sumAllValue = new Paragraph($centerText);
if(isset($_POST['sumAll'])){
	$sumAllValue->addText($_POST['sumAll']);
}
$rows = array(array('', $sumAll, $sumAllValue, ''));
$table->addRows($rows, true, null, null);

$p = new Paragraph($jstText);
$p->addText("Для характеристики уровня освоения учебного материала используются следующие обозначения:");

$p = new Paragraph($jstText);
$p->addText("1. - ознакомительный (узнавание ранее изученных объектов, свойств); ");

$p = new Paragraph($jstText);
$p->addText("2. - репродуктивный (выполнение деятельности по образцу, инструкции или под руководством);");

$p = new Paragraph($jstText);
$p->addText("3. - продуктивный (планирование и самостоятельное выполнение деятельности, решение проблемных задач);");

addBlankLines(2);

//===========================================
// * PAGE 8
//===========================================

//===========================================
// * Делаем страницу снова портретной
//===========================================
$pTest3 = new Paragraph($p3t);
$pTest3->addText("");

addBlankLines(2);

$p = new Paragraph($centeredText);
$p->addText("3. УСЛОВИЯ РЕАЛИЗАЦИИ ПРОГРАММЫ УЧЕБНОЙ ДИСЦИПЛИНЫ", $bolded);

addBlankLines(1);

$p = new Paragraph($centeredText);
$p->addText("3.1. Требования к минимальному материально-техническому обеспечению", $bolded);

addBlankLines(2);

$p = new Paragraph($jstText);
$p->addText("Реализация программы учебной дисциплины требует наличия:", $frt);

$cabHead = $labHead = $polHead = $stHead = $spHead = $zalHead = false;

for ($i = 1; $i <= $_POST['croomCount']; $i++) {
	if (isset($_POST['Кабинеты'.$i])) {
		if ($cabHead == false) {
			$p = new Paragraph($jstText);
			$p->addText("Учебных кабинетов: ", $frt);
			$cabHead = true;
		}
		$p->addText($_POST['Кабинеты'.$i]."; ", $frt);
	}
	if (isset($_POST['Лаборатории'.$i])) {
		if ($labHead == false) {
			$p = new Paragraph($jstText);
			$p->addText("Лабораторий: ", $frt);
			$labHead = true;
		}
		$p->addText($_POST['Лаборатории'.$i]."; ", $frt);
	}
	if (isset($_POST['Полигоны'.$i])) {
		if ($polHead == false) {
			$p = new Paragraph($jstText);
			$p->addText("Полигонов: ", $frt);
			$polHead = true;
		}
		$p->addText($_POST['Полигоны'.$i]."; ", $frt);
	}
	if (isset($_POST['Студии'.$i])) {
		if ($stHead == false) {
			$p = new Paragraph($jstText);
			$p->addText("Студий: ", $frt);
			$stHead = true;
		}
		$p->addText($_POST['Студии'.$i]."; ", $frt);
	}
	if (isset($_POST['Спортивный_комплекс'.$i])) {
		if ($spHead == false) {
			$p = new Paragraph($jstText);
			$p->addText("Спортивных комплексов: ", $frt);
			$spHead = true;
		}
		$p->addText($_POST['Спортивный_комплекс'.$i]."; ", $frt);
	}
	if (isset($_POST['Залы'.$i])) {
		if ($zalHead == false) {
			$p = new Paragraph($jstText);
			$p->addText("Залов: ", $frt);
			$zalHead = true;
		}
		$p->addText($_POST['Залы'.$i]."; ", $frt);
	}
}

addBlankLines(2);

if (!isset($_POST['um0']) || $_POST['um0'] != '') {
	$p = new Paragraph($jstText);
	$p->addText("Оборудование учебного кабинета:", $frt);
}

$list = new ODTList(array());
for ($i = 0; $i <= $_POST['countEqUm']; $i++) {
	if (isset($_POST['um'.$i]) && $_POST['um'.$i] != '') {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['um'.$i].";", $frt);
		$list->addItem($p);
	} 
}

addBlankLines(1);

if (!isset($_POST['tso0']) || $_POST['tso0'] != '') {
	$p = new Paragraph($jstText);
	$p->addText("Технические средства обучения:", $frt);
}

/* $p = new Paragraph($jstText);
$p->addText("Технические средства обучения:", $frt); */
$list = new ODTList(array());
for ($i = 0; $i <= $_POST['countEqTso']; $i++) {
	if (isset($_POST['tso'.$i]) && $_POST['tso'.$i] != '') {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['tso'.$i].";", $frt);
		$list->addItem($p);
	} 
}

addBlankLines(1);

if (!isset($_POST['mas0']) || $_POST['mas0'] != '') {
	$p = new Paragraph($jstText);
	$p->addText("Оборудование мастерской и рабочих мест мастерской:", $frt);
}

/* $p = new Paragraph($jstText);
$p->addText("Оборудование мастерской и рабочих мест мастерской: ", $frt); */
$list = new ODTList(array());
for ($i = 0; $i <= $_POST['countEqMas']; $i++) {
	if (isset($_POST['mas'.$i]) && $_POST['mas'.$i] != '') {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['mas'.$i].";", $frt);
		$list->addItem($p);
	} 
}

addBlankLines(1);

if (!isset($_POST['eqLab0']) || $_POST['eqLab0'] != '') {
	$p = new Paragraph($jstText);
	$p->addText("Оборудование лаборатории и рабочих мест лаборатории:", $frt);
}

/* $p = new Paragraph($jstText);
$p->addText("Оборудование лаборатории и рабочих мест лаборатории: ", $frt); */
$list = new ODTList(array());
for ($i = 0; $i <= $_POST['countEqLab']; $i++) {
	if (isset($_POST['eqLab'.$i]) && $_POST['eqLab'.$i] != '') {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['eqLab'.$i].";", $frt);
		$list->addItem($p);
	} 
}

addBlankLines(1);

$p = new Paragraph($centeredText);
$p->addText("3.2.  Информационное обеспечение обучения", $bolded);

addBlankLines(1);

$p = new Paragraph($jstText);
$p->addText("Перечень рекомендуемых учебных изданий, Интернет-ресурсов, дополнительной литературы", $frt);

$p = new Paragraph($jstText);
$p->addText("Основные источники:", $frt);

$list = new ODTList(array());
for ($i = 0; $i <= $_POST['countOLit']; $i++) {
	if (isset($_POST['oLit'.$i])) {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['oLit'.$i].";", $frt);
		$list->addItem($p);
	} 
}

$p = new Paragraph($jstText);
$p->addText("Дополнительные источники:", $frt);

$list = new ODTList(array());
for ($i = 0; $i <= $_POST['countDLit']; $i++) {
	if (isset($_POST['dLit'.$i])) {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['dLit'.$i].";", $frt);
		$list->addItem($p);
	} 
}

// addBlankLines(2);

$dummy = new Paragraph($withBreak);
$dummy->addText(""); 

//===========================================
// * PAGE 9
//===========================================

addBlankLines(2);

$p = new Paragraph($centeredText);
$p->addText("4.  КОНТРОЛЬ И ОЦЕНКА РЕЗУЛЬТАТОВ ОСВОЕНИЯ  УЧЕБНОЙ ДИСЦИПЛИНЫ", $bolded);

addBlankLines(2);

$p = new Paragraph($jstText);
$p->addText("Контроль и оценка результатов освоения учебной дисциплины осуществляется преподавателем в процессе проведения практических занятий и лабораторных работ, тестирования, а также выполнения обучающимися индивидуальных заданий, проектов, исследований.", $frt);

addBlankLines(1);

$table = new Table('table5');
$tableStyle = new TableStyle($table->getTableName());
$table->createColumns(2);


$str = new Paragraph($centeredText);
$str->addText("Результаты обучения (освоенные умения, усвоенные знания)", $bolded);
$str1 = new Paragraph($centeredText);
$str1->addText("Формы и методы контроля и оценки результатов обучения ", $bolded);
$rows = array(array($str, $str1));
$table->addRows($rows, true, null, null);

$str = new Paragraph($leftText);
$str->addText("Умения", $bolded);
$str1 = new Paragraph($leftText);
$str1->addText("", $bolded);
$rows = array(array($str, $str1));
$table->addRows($rows, true, null, null);

// умения
for ($i = 1; ; $i++) {
	if (isset($_POST['Skill'.$i])) {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['Skill'.$i], $frt);
		$rows = array(array($p, ""));
		$table->addRows($rows, true, null, null);
	} else {
		break;
	}
}


$str = new Paragraph($leftText);
$str->addText("Знания", $bolded);
$str1 = new Paragraph($leftText);
$str1->addText("", $bolded);
$rows = array(array($str, $str1));
$table->addRows($rows, true, null, null);

// знания
for ($i = 1; ; $i++) {
	if (isset($_POST['Knowledge'.$i])) {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['Knowledge'.$i], $frt);
		$rows = array(array($p, ""));
		$table->addRows($rows, true, null, null);
	} else {
		break;
	}
}


$str = new Paragraph($centeredText);
$str->addText("Результаты обучения (освоенные ПК, ОК)", $bolded);
$str1 = new Paragraph($centeredText);
$str1->addText("Формы и методы контроля и оценки результатов обучения ", $bolded);
$rows = array(array($str, $str1));
$table->addRows($rows, true, null, null);

for ($i = 1; ; $i++) {
	if (isset($_POST['PC'.$i])) {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['PC'.$i], $frt);
		$rows = array(array($p, ""));
		$table->addRows($rows, true, null, null);
	} else {
		break;
	}
}

for ($i = 1; ; $i++) {
	if (isset($_POST['GC'.$i])) {
		$p = new Paragraph($jstText, false);
		$p->addText($_POST['GC'.$i], $frt);
		$rows = array(array($p, ""));
		$table->addRows($rows, true, null, null);
	} else {
		break;
	}
}


















$date = date("d-m-y");
//$fileName = $_POST['specialty']." ".$_POST['disc']." ".$date.".odt";
//$fileName = rus2translit($fileName);

$odt->output($fileName);
//header("Location:".$fileName);

?>

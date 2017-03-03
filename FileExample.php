<?php 

/** 
 * Description of filereader 
 * The file has following functions 
 * 
 * Function 1 - reads each character 
 * 1. charreader($filename) 
 * Function 2 - reads each character into array 
 * 2. chararrayreader($filename) 
 * Function 3 - reads file contents into array 
 * 3. arrayreader($filename) 
 * Funtion 4 - searches for similar words/ phrase in file, case sensitive 
 * 4. searchwordcase($filename, $words) 
 * Funtion 5 - searches for similar words/ phrase in file, case insensitive 
 * 5. searchwordnocase($filename, $words) 
 * 
 * @author: GB 
 * @email: ganeshsurfs@gmail.com 
 * @Website: N.A. 
 */ 

include "FileReader.php"; 

 $testreader = new filereader(); 
$tempobject = $testreader->charreader("testing.txt"); 
print_r($tempobject); 
print "<br>Charreader function done<br>"; 
echo "<plaintext>";
$tempobject = ""; 
$tempobject = $testreader->chararrayreader("webform.php"); 
var_dump($tempobject); 
print "<br>Chararrayreader function done<br>"; 
echo "</plaintext>";
$tempobject = ""; 
$tempobject = $testreader->arrayreader("testing.txt"); 
print_r($tempobject); 
print "<br>arrayreader function done<br>"; 

$tempobject = ""; 
$tempobject = $testreader->searchwordcase("testing.txt",'LINE'); 
print_r ($tempobject); 
print "<br>search word case sensitive function done <br>"; 

$tempobject = ""; 
$tempobject = $testreader->searchwordnocase("testing.txt",'first LINE'); 
print_r($tempobject); 
print "<br>search word case insensitive function done <br>"; 



print "<br><br> Ending code testing \n"; 





?> 
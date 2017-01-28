<?php
include './functions/includes.php';
//ini_set('display_errors',1);
//error_reporting(E_ALL);

include './classes/safemysql.class.php';
	$db = new SafeMysql();

	if(!empty($_POST['jsonData'])){
		$data1 = json_decode($_POST['jsonData'], true);
	}

$dataArr = array();

function quer($select, $condition){
	global $db;
	$where = "WHERE ".implode(' AND ', $condition);
	$res = $db->query($select, $where);
	return $res;
}

function switchFunc($function){
	global $db;
	global $data1;
	global $dataArr;
	$w = array();
	$data = "";

	switch($function) {
//Дисциплина:
		case 1:
		//для webform.php
			if (!empty($data1['spec'])){
				$idSpecialty = strip_tags($data1['spec']);
				$idSpecialty = intval($idSpecialty);
				$idSpecialty = htmlspecialchars($idSpecialty);
				$sql = "SELECT idSuSp, subj_code, SubjName FROM Subject as Su, Specialty as Sp, Subj_Spec as SS, SubjCode as SC ?p ORDER BY `SC`.`subj_code` ASC;";
				$w[] = $db->parse("SS.idSpecialty = Sp.idSpecialty");
				$w[] = $db->parse("Sp.idSpecialty = ?i", $idSpecialty);
				$w[] = $db->parse("SS.idSubject = Su.idSubject");
				$w[] = $db->parse("SS.idSubjcode = SC.idSubjcode");
				$Subject = quer($sql, $w);
				$style = "";
				$numRow = 0;
				while ($row = $Subject->fetch_array()) {
					$data .= "<option id = ".$row[0]." value = '".$row[1]." ".$row[2]."' ".$style.">".$row[1]." ".$row[2]."</option>";
					$numRow++;
					if ($numRow % 2 != 0) {
						$style = "style='background-color:#DFDFDF'";
					} else {
						$style = "";
					}
				}
			}//для dataspec.php
			else if (!empty($data1['subjtype'])){
				$idSubjtype = intval($data1['subjtype']);
				$sql = "SELECT idSubject, SubjName FROM Subject as Su, SubjTypes as ST ?p";
				$w[] = $db->parse("Su.idSubjType = ST.idSubjType");
				$w[] = $db->parse("Su.idSubjType = ?i", $idSubjtype);
				$Subject = quer($sql, $w);
				while ($row = $Subject->fetch_array()) {
					$data .= "<option id = ".$row[0]." value = '".$row[1]."'>".$row[1]."</option>";
				}
			}
		break;
//Профессиональные компетенции:
		case 2:
		//для webform.php
			if (!empty($data1['disc']) && !empty($data1['spec'])){
				$idSuSp = intval($data1['disc']);
				$idSpecialty = intval($data1['spec']);
				$n=0;
				$sql = "SELECT PCC.PCompCode, PC.PCompCont FROM ProfComp as PC, PCCode as PCC, Subj_PComp as SP, Subj_Spec as SS ?p";
				$w[] = $db->parse("SP.idSuSp = SS.idSuSp");
				$w[] = $db->parse("SS.idSuSp = ?i", $idSuSp);
				$w[] = $db->parse("PC.idSpecialty = ?i", $idSpecialty);
				$w[] = $db->parse("SP.idPComp = PC.idPComp");
				$w[] = $db->parse("PCC.idPCCode = PC.idPCCode");
				$PC = quer($sql, $w);
				while ($row = $PC->fetch_array()) {
					$n++;
					$data .= "<input hidden value ='".$row[0]." ".$row[1]."' name ='PC".$n."'>";
				}
			}
			//для datasubjspec.php
			else  if (!empty($data1['spec']) && empty($data1['disc'])){
				$idSpecialty = intval($data1['spec']);
				$sql = "SELECT PC.idPComp, PCC.PCompCode, PC.PCompCont FROM ProfComp as PC, PCCode as PCC ?p and PC.idPComp not in(select idPComp from Subj_PComp where idSuSp = '".$data1['susp']."')";
				$w[] = $db->parse("PC.idSpecialty = ?i", $data1['spec']);
				$w[] = $db->parse("PCC.idPCCode = PC.idPCCode"); 
				$PC = quer($sql, $w);
				while ($row = $PC->fetch_array()) {
					$data .= "<input type = checkbox id = '".$row[0]."' value = '".$row[0]."' class = 'PCcheckbox1'> ".$row[1]." ".$row[2]."<br>";
				}
			}
		break;
//Учебные помещения:
		case 3:
		//для dataspec.php
			if (!empty($data1['roomtype']) && empty($data1['spec'])){
				$idCRoomType = intval($data1['roomtype']);
				$sql = "SELECT CR.idCRoom, CR.CRoom FROM Classrooms as CR, CRoomTypes as CRT ?p and CR.idCRoom NOT IN (SELECT idCRoom FROM CRoom_Spec) ORDER BY `CR`.`CRoom` ASC";
				$w[] = $db->parse("CRT.idCRoomType = CR.idCRoomType");
				$w[] = $db->parse("CR.idCRoomType = ?i", $idCRoomType);
				$CRoom = quer($sql, $w);
				while ($row = $CRoom->fetch_array()) {
					$data .= "<input type = checkbox id = '".$row[0]."' class = 'CRoomcheck'>".$row[1]."<br>";
				}//для webform.php
			}else if (!empty($data1['spec']) && empty($data1['roomtype'])){
				$idSpecialty = intval($data1['spec']);
				$data = "<table  style='border: 3px;'  class = 'table table-bordered'><th>Типы учебных помещений</th><th colspan = 2>Наименование помещения</th>";
				$n = 0;
				$sql = "SELECT CRS.idSpecialty, CRS.idCRoom, CRT.CRoomType, CRoom FROM Specialty as S, Classrooms as CR, CRoomTypes as CRT, CRoom_Spec as CRS ?p";
				for($i=1;$i<9;$i++){
					$w[] = $db->parse("S.idSpecialty = ?i", $idSpecialty);
					$w[] = $db->parse("CRS.idCRoom = CR.idCRoom");
					$w[] = $db->parse("CRS.idSpecialty = S.idSpecialty");
					$w[] = $db->parse("CR.idCRoomType = CRT.idCRoomType");
					$w[] = $db->parse("CR.idCRoomType = ?s", $i);//для чего мы это сделали?
					$CRoom = quer($sql, $w);
					unset($w);
					while ($row = $CRoom->fetch_array()) {
						$name = str_replace(' ', '_', $row[2]);
						$n++;
						$data .="<tr><td>".$row[2]."</td><td><input type = checkbox id = 'spec".$row[0]."croom".$row[1]."' name = '".$name.$n."' value = '".$row[3]."'></td><td>".$row[3]."</td></tr>"; 
					}
				}
				$data .="<input hidden value = '".$n."' name = 'croomCount'></table>";
			}
		break;
//Индекс дисциплины
		case 4:
		//для dataspec.php
		if(!empty($data1['subjtype'])){
			$idSubjType = intval($data1['subjtype']);
			$sql = "SELECT idSubjcode, subj_code FROM SubjCode as SC, SubjTypes as ST ?p";
			$w[] = $db->parse("SC.idSubjType = ST.idSubjType");
			$w[] = $db->parse("ST.idSubjType = ?i", $idSubjType);
			$SubjCode = quer($sql, $w);
			while ($row = $SubjCode->fetch_array()) {
				$data .= "<option id = ".$row[0]." value = '".$row[1]."'>".$row[1]."</option>";
			}
		}
		break;
//Умения
		case 5:
		//для datasubjspec.php
		if(!empty($data1['susp'])){
			$idSuSp = intval($data1['susp']);
			$sql = "SELECT S.idSkills, S.SkillCont from Skills as S, Subj_Spec as SS, Subject as Su ?p and S.idSkills not in(select idSkills from Subj_Skill where idSuSp = '".$idSuSp."')";
			$w[] = $db->parse("Su.idSubject = S.idSubject");
			$w[] = $db->parse("SS.idSubject = S.idSubject");
			$w[] = $db->parse("SS.idSuSp = ?i", $idSuSp);
			$Skill = quer($sql, $w);
			while ($row = $Skill->fetch_array()) {
				$data .= "<input type = checkbox id = ".$row[0]." value = '".$row[1]."' class = 'Skillcheckbox1'>".$row[1]."<br>";
			}
		}//для webform.php
		else if (!empty($data1['disc'])){
			$idSuSp = intval($data1['disc']);
			$n=0;
			$sql = "SELECT S.SkillCont FROM Skills as S, Subj_Skill as SuSk, Subj_Spec as SS ?p";
			$w[] = $db->parse("SuSk.idSuSp = SS.idSuSp");
			$w[] = $db->parse("SuSk.idSkills = S.idSkills");
			$w[] = $db->parse("SuSk.idSuSp = ?i", $idSuSp);
			$Skill = quer($sql, $w);
			while ($row = $Skill->fetch_array()) {
				$n++;
				$data .= "<input hidden value ='".$row[0]."' name ='Skill".$n."'>"; 
			}
		}
		break;
//Знания
		case 6:
		//для datasubjspec.php
		if(!empty($data1['susp'])){
			$idSuSp = intval($data1['susp']);
			$data = '';
			$sql = "SELECT K.idKnowledge, K.KnowCont from Knowledge as K, Subj_Spec as SS, Subject as Su ?p and K.idKnowledge not in(select  idKnowledge from Subj_Knowledge where idSuSp = '".$idSuSp."')";
			$w[] = $db->parse("Su.idSubject = K.idSubject");
			$w[] = $db->parse("SS.idSubject = K.idSubject");
			$w[] = $db->parse("SS.idSuSp = ?i", $idSuSp);
			$Knowledge = quer($sql, $w);
			while ($row = $Knowledge->fetch_array()) {
				$data .= "<input type = checkbox id = ".$row[0]." value = '".$row[1]."' class = 'Knowcheckbox1'>".$row[1]."<br>";
			}
			}//для webform.php
		else if (!empty($data1['disc'])){
			$idSuSp = intval($data1['disc']);
			$n=0;
			$sql = "SELECT K.KnowCont FROM Knowledge as K, Subj_Knowledge as SuKn, Subj_Spec as SS ?p";
			$w[] = $db->parse("SuKn.idSuSp = SS.idSuSp");
			$w[] = $db->parse("SuKn.idKnowledge = K.idKnowledge");
			$w[] = $db->parse("SuKn.idSuSp = ?i", $idSuSp);
			$Knowledge = quer($sql, $w);
			while ($row = $Knowledge->fetch_array()) {
				$n++;
				$data .= "<input hidden value ='".$row[0]."' name ='Knowledge".$n."'>"; 
			}
		}
		break;
//Общие компетенции:
		case 7:
		//для datasubjspec.php
		if (!empty($data1['spec']) && !empty($data1['susp'])){
			$idSpecialty = intval($data1['spec']);
			$idSuSp = intval($data1['susp']);
			$sql = "SELECT GC.idGenComp, GC.GCompCode, GC.GCompCont from GenComp as GC, GC_Spec as GCS, Specialty as S ?p and GC.idGenComp not in(select idGenComp from Subj_GComp where idSuSp = '".$idSuSp."')";
			$w[] = $db->parse("GC.idGenComp = GCS.idGenComp");
			$w[] = $db->parse("GCS.idSpecialty = S.idSpecialty");
			$w[] = $db->parse("GCS.idSpecialty = ?i", $idSpecialty);
			$GenComp = quer($sql, $w);
			while ($row = $GenComp->fetch_array()) {
				$data .= "<input type = checkbox id = ".$row[0]." value = '".$row[1]."' class = 'GCcheckbox1'>".$row[1]." ".$row[2]."<br>";
			}
		}//для webform.php
		else if (!empty($data1['disc'])){
				$idSuSp = intval($data1['disc']);
				$n=0;
				$sql = "SELECT GC.idGenComp, GC.GCompCode, GC.GCompCont FROM GenComp as GC, Subj_GComp as SGC, Subj_Spec as SS ?p";
				$w[] = $db->parse("SGC.idSuSp = SS.idSuSp");
				$w[] = $db->parse("SS.idSuSp = ?i", $idSuSp);
				$w[] = $db->parse("SGC.idGenComp = GC.idGenComp");
				$GenComp = quer($sql, $w);
				while ($row = $GenComp->fetch_array()) {
					$n++;
					$data .= "<input hidden value ='".$row[1]." ".$row[2]."' name ='GC".$n."'>"; 
				}
			}
		break;
		case 8:
			$idSuSp = intval($data1['susp']);
			$data = '';
			$sql = "SELECT PX.idPractEx, PX.PractExCont from PractEx as PX, Subj_Spec as SS, Subject as Su ?p and PX.idPractEx not in (select  idPractEx from Subj_PractEx where idSuSp = '".$idSuSp."')";
			$w[] = $db->parse("Su.idSubject = PX.idSubject");
			$w[] = $db->parse("SS.idSubject = PX.idSubject");
			$w[] = $db->parse("SS.idSuSp = ?i", $idSuSp);
			$PractEx = quer($sql, $w);
			while ($row = $PractEx->fetch_array()) {
				$data .= "<input type = checkbox id = ".$row[0]." value = '".$row[1]."' class = 'PractExCheckbox1'>".$row[1]."<br>";
			}
		break;
	}
	$dataArr[] = $data;
}

function echoResponse(){
	global $dataArr;
	global $data1;
	$func_lenght = count($data1['func']);
	for($i=0;$i<$func_lenght;$i++){
		$func2 = $data1['func'][$i];
		switchFunc($func2);
	}
	if(!empty($dataArr)){
		echo json_encode($dataArr);
	}
}
	
echoResponse();
	
//Для вставки в таблицы на страницах управления данными БД
//Функция, выполняющая запрос к базе данных
	function dataselect($tables, $condition=null, $fields="*"){
		global $db;
		$where = ($condition)? "WHERE ".implode(' AND ', $condition): null;
		$fields=="*"?$fieldsres="*":$fieldsres = "`".$fields."`";
		$tablesres = "`".$tables."`";
		if($condition==null){
			$sql = "SELECT  ?p FROM  ?p";
			$dataArr1 = $db->query($sql, $fieldsres, $tablesres);
		}else{
			$sql = "SELECT  ?p FROM  ?p ?p";
			$dataArr1 = $db->query($sql, $fieldsres, $tablesres, $where);
		}
		return $dataArr1; 
	}
//таблица пользователей на странице datauser.php
	function User_Table(){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('U`.`id', 'U`.`username', 'U`.`FName', 'U`.`LName', 'U`.`PName', 'UR`.`Role', 'UR`.`idRole'));
		$tables = implode("`, `", array('users` as `U', 'UserRoles` as `UR'));
		$w[] = $db->parse("U.idRole = UR.idRole");
		$Role = dataselect($tables, $w, $fields);
		$n = 0;
		while ($row = $Role->fetch_array()) {
			++$n;
			$data1 .= "<tr id = '".$row[0]."'><td>".$row[0]."</td>";
			$data1 .= "<td>".$row[1]."</td>";
			$data1 .= "<td contenteditable='true'>".$row[2]."</td>";
			$data1 .= "<td contenteditable='true'>".$row[3]."</td>";
			$data1 .= "<td contenteditable='true'>".$row[4]."</td>";
			$data1 .= "<td class = 'rolerows1' id = 'role".$n."'>".$row[5]."<input hidden value='".$row[6]."'></td>";
			$data1 .= "<td><button class = 'btn btn-primary' id = 'EditUsers".$row[0]."' onclick = editButton(this,'users'); style = 'width:100%;'>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelUsers".$row[0]."' onclick = delButton(this,'users'); style = 'width:100%;'>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица предметов специальности на странице dataspec.php
	function Subject_Table($idSpecialty){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('idSuSp', 'subj_code', 'SubjName', 'SC`.`idSubjcode', 'Su`.`idSubject'));
		$tables = implode("`, `", array('Subject` as `Su', 'Specialty` as `Sp', 'Subj_Spec` as `SS', 'SubjCode` as `SC'));
		$w[] = $db->parse("SS.idSpecialty = Sp.idSpecialty");
		$w[] = $db->parse("Sp.idSpecialty = ?s", $idSpecialty);
		$w[] = $db->parse("SS.idSubject = Su.idSubject");
		$w[] = $db->parse("SS.idSubjcode = SC.idSubjcode");
		$Subject = dataselect($tables, $w, $fields);
		$n = 0;
		while ($row = $Subject->fetch_array()) {
			++$n;
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td class = 'scrows' id = '".$row[1]."'>".$row[1]."<input hidden value='".$row[3]."'></td>";
			$data1 .= "<td class = 'subjrows' id = 'Subj".$n."'>".$row[2]."<input hidden value='".$row[4]."'></td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'EditSubj".$row[0]."' style='width:100%;' onclick = editButton(this,'Subj_Spec');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'EditDataSubj".$row[0]."' style='width:100%;' onclick = editDatasubj(this);>Наборы дисциплины</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelSubj".$row[0]."' style='width:100%;' onclick = delButton(this,'Subj_Spec')>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица предметов на странице datasubj.php
	function NewSubject_Table(){
		global $db;
		$data1 = '<table id = "SubjectTable" class = "table table-bordered"><tr><th class = "CODECOL">Дисциплина (для редактирования - 1 клик)</th><th>Тип дисциплины (для изменения - 2 клика)</th><th class = "BUTTCOLL">Операции</th></tr>';
		$fields = implode("`, `", array('Su`.`idSubject', 'Su`.`SubjName', 'ST`.`STypeCode', 'Su`.`idSubjType'));
		$tables = implode("`, `", array('Subject` as `Su', 'SubjTypes` as `ST'));
		$w[] = $db->parse("Su.idSubjType = ?s", $_POST['idSubjType']);
		$w[] = $db->parse("Su.idSubjType = ST.idSubjType");
		$Subject = dataselect($tables, $w, $fields);
		$n=0;
		while ($row = $Subject->fetch_array()) {
			$n++;
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td contenteditable='true'>".$row[1]."</td>";
			$data1 .= "<td class = 'styperows' id = 'styperows".$n."'>".$row[2]."<input hidden value = '".$row[3]."'></td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' style='width:100%;' id = 'EditSubject".$row[0]."' onclick = editButton(this,'Subject');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelSubject".$row[0]."' style='width:100%;' onclick = delButton(this,'Subject');>Удалить</button></td></tr>";
		}
		$data1.="</table>";
		echo $data1;
	}
//таблица профессиональных компетенций  специальности на странице dataspec.php
	function PC_Table($idSpecialty){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('PC`.`idPComp', 'PCC`.`PCompCode', 'PC`.`PCompCont', 'PC`.`idPCCode'));
		$tables = implode("`, `", array('ProfComp` as `PC', 'PCCode` as `PCC'));
		$w[] = $db->parse("PC.idSpecialty = ?s",$idSpecialty);
		$w[] = $db->parse("PCC.idPCCode = PC.idPCCode");
		$PC = dataselect($tables, $w, $fields);
		while ($row = $PC->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td id = '".$row[3]."'>".$row[1]."</td>";
			$data1 .= "<td contenteditable='true'>".$row[2]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'EditPC".$row[0]."' style='width:100%;' onclick = editButton(this,'ProfComp');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelPC".$row[0]."' style='width:100%;' onclick = delButton(this,'ProfComp');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица профессиональных компетенций дисциплины специальности на странице datasubjspec.php
	function PC_Table2($idSuSp){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('SPC`.`idSPC', 'PCC`.`PCompCode', 'PC`.`PCompCont'));
		$tables = implode("`, `", array('ProfComp` as `PC', 'PCCode` as `PCC', 'Subj_PComp` as `SPC'));
		$w[] = $db->parse("SPC.idSuSp = ?s",$idSuSp);
		$w[] = $db->parse("SPC.idPComp = PC.idPComp");
		$w[] = $db->parse("PCC.idPCCode = PC.idPCCode"); 
		$ProfComp = dataselect($tables, $w, $fields);
		while ($row = $ProfComp->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td>".$row[1]."</td>";
			$data1 .= "<td>".$row[2]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'DelCR".$row[0]."' style='width:100%;' onclick = delButton(this,'Subj_PComp');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица общих компетенций специальности на странице dataspec.php
	function GC_Table($idSpecialty){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('GCS`.`idGCompSpec', 'GC`.`GCompCode', 'GC`.`GCompCont'));
		$tables = implode("`, `", array('GenComp` as `GC', 'GC_Spec` as `GCS', 'Specialty` as `S'));
		$w[] = $db->parse("GC.idGenComp = GCS.idGenComp");
		$w[] = $db->parse("GCS.idSpecialty = S.idSpecialty");
		$w[] = $db->parse("GCS.idSpecialty = ?s", $idSpecialty);
		$GenComp= dataselect($tables, $w, $fields);
		while ($row = $GenComp->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td>".$row[1]."</td>";
			$data1 .= "<td>".$row[2]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'DelGC".$row[0]."' style='width:100%;' onclick = delButton(this,'GC_Spec');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица общих компетенций дисциплины специальности на странице datasubjspec.php	
	function GC_Table2($idSuSp){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('SGC`.`idSGC', 'GC`.`GCompCode', 'GC`.`GCompCont'));
		$tables = implode("`, `", array('GenComp` as `GC', 'Subj_GComp` as `SGC', 'Subj_Spec` as `SS'));
		$w[] = $db->parse("SGC.idSuSp = SS.idSuSp");
		$w[] = $db->parse("SS.idSuSp = ?s", $idSuSp);
		$w[] = $db->parse("SGC.idGenComp = GC.idGenComp");
		$GenComp = dataselect($tables, $w, $fields);
		while ($row = $GenComp->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td>".$row[1]."</td>";
			$data1 .= "<td>".$row[2]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'DelCR".$row[0]."' style='width:100%;' onclick = delButton(this,'Subj_GComp');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица общих компетенций на странице datacompet.php		
	function GC_Table3(){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('GC`.`idGenComp', 'GC`.`GCompCode', 'GC`.`GCompCont', 'CM`.`ContMark', 'GC`.`idContMark'));
		$tables = implode("`, `", array('GenComp` as `GC', 'ControlMarks` as `CM'));
		$w[] = $db->parse("CM.idContMark = GC.idContMark");
		$GenComp = dataselect($tables, $w, $fields);
		while ($row = $GenComp->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."'><td>".$row[1]."</td>";
			$data1 .= "<td contenteditable='true'>".$row[2]."</td>";
			$data1 .= "<td id = 'ContMark".$row[4]."' class = 'gcrows'>".$row[3]."<input hidden id ='contmarkid' value = '".$row[4]."'></td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'EditGC".$row[0]."' style='width:100%;' onclick = editButton(this,'GenComp');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelGC".$row[0]."' style='width:100%;' onclick = delButton(this,'GenComp');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица учебных помещений специальности на странице dataspec.php	
	function CR_Table($idSpecialty){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('CRS`.`idCRS', 'CRT`.`CRoomType', 'CRoom'));
		$tables = implode("`, `", array('Specialty` as `S', 'Classrooms` as `CR', 'CRoomTypes` as `CRT', 'CRoom_Spec` as `CRS'));
		$w[] = $db->parse("S.idSpecialty = ?s", $idSpecialty);
		$w[] = $db->parse("CRS.idCRoom = CR.idCRoom");
		$w[] = $db->parse("CRS.idSpecialty = S.idSpecialty");
		$w[] = $db->parse("CR.idCRoomType = CRT.idCRoomType");
		$CRoom = dataselect($tables, $w, $fields);
		while ($row = $CRoom->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td>".$row[1]."</td>";
			$data1 .= "<td>".$row[2]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'DelCR".$row[0]."' style='width:100%;' onclick = delButton(this,'CRoom_Spec');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица учебных помещений на странице datacroom.php		
	function CR_Table2(){
		global $db;
		$data1 = '<table id = "CRTable" class = "table table-bordered"><tr><th class = "CODECOL">Тип уч. помещения</th><th>Наименование уч. помещения</th><th class = "BUTTCOLL">Операции</th></tr>';
		$fields = implode("`, `", array('CR`.`idCRoom', 'CRT`.`CRoomType', 'CR`.`CRoom'));
		$tables = implode("`, `", array('Classrooms` as `CR', 'CRoomTypes` as `CRT'));
		$w[] = $db->parse("CRT.idCRoomType = ?s", $_POST['idCRType']);
		$w[] = $db->parse("CR.idCRoomType = CRT.idCRoomType");
		$w[] = $db->parse("CR.idCRoomType = ?s", $_POST['idCRType']);
		$CRoom = dataselect($tables, $w, $fields);
		while ($row = $CRoom->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td>".$row[1]."</td>";
			$data1 .= "<td contenteditable='true'>".$row[2]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'EditCR".$row[0]."' style='width:100%;' onclick = editButton(this,'Classrooms');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelCR".$row[0]."' style='width:100%;' onclick = delButton(this,'Classrooms');>Удалить</button></td></tr>";
		}
		$data1 .="</table>";
		echo $data1;
	}
//таблица знаний дисциплины специальности на странице datasubjspec.php		
	function Knowledge_Table($idSuSp){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('SuKn`.`idSuKn', 'K`.`KnowCont'));
		$tables = implode("`, `", array('Knowledge` as `K', 'Subj_Knowledge` as `SuKn', 'Subj_Spec` as `SS'));
			$w[] = $db->parse("SuKn.idSuSp = SS.idSuSp");
			$w[] = $db->parse("SuKn.idKnowledge = K.idKnowledge");
			$w[] = $db->parse("SuKn.idSuSp = ?s",$idSuSp);
		$Knowledge = dataselect($tables, $w, $fields);
		while ($row = $Knowledge->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."'><td>".$row[1]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'DelCR".$row[0]."' style='width:100%;' onclick = delButton(this,'Subj_Knowledge');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица знаний дисциплины на странице datasubj.php	
	function Knowledges_Table(){
		global $db;
		$data1 = '<table id = "KnowledgeTable" style = "border: 4px solid black;"><tr><th>Содержание (для редактирования - 1 клик)</th><th class = "BUTTCOLL">Операции</th></tr>';
		$tables = implode("`, `", array('Knowledge` as `Kn'));
		$w[] = $db->parse("Kn.idSubject = ?s", $_POST['idSubject']);
		$Knowledge = dataselect($tables, $w);
		while ($row = $Knowledge->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td contenteditable='true'>".$row[1]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' style='width:100%;' id = 'EditCR".$row[0]."' onclick = editButton(this,'Knowledge');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelCR".$row[0]."' style='width:100%;'onclick = delButton(this,'Knowledge');>Удалить</button></td></tr>";
		}
		$data1.="</table>";
		echo $data1;
	}
//таблица умений дисциплины специальности на странице datasubjspec.php
	function Skill_Table($idSuSp){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('SuSk`.`idSuSk', 'S`.`SkillCont'));
		$tables = implode("`, `", array('Skills` as `S', 'Subj_Skill` as `SuSk', 'Subj_Spec` as `SS'));
			$w[] = $db->parse("SuSk.idSuSp = SS.idSuSp");
			$w[] = $db->parse("SuSk.idSkills = S.idSkills");
			$w[] = $db->parse("SuSk.idSuSp = ?s", $idSuSp);
		$Skill = dataselect($tables, $w, $fields);
		while ($row = $Skill->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."'><td>".$row[1]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'DelCR".$row[0]."' style='width:100%;' onclick = delButton(this,'Subj_Skill');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица умений дисциплины на странице datasubj.php	
	function Skills_Table(){
		global $db;
		$data1 = '<table id = "SkillTable" style = "border: 4px solid black;"><tr><th>Содержание (для редактирования - 1 клик)</th><th class = "BUTTCOLL">Операции</th></tr>';
		$tables = implode("`, `", array('Skills` as `Sk'));
		$w[] = $db->parse("Sk.idSubject = ?s", $_POST['idSubject']);
		$Skill = dataselect($tables, $w);
		while ($row = $Skill->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td contenteditable='true'>".$row[1]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' style='width:100%;' id = 'EditCR".$row[0]."' onclick = editButton(this,'Skills');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' style='width:100%;' id = 'DelCR".$row[0]."' onclick = delButton(this,'Skills');>Удалить</button></td></tr>";
		}
		$data1.="</table>";
		echo $data1;
	}
//таблица типов учебных помещений на странице datacroom.php	
	function CRoomType_Table(){
		global $db;
		$data1 = "";
		$tables = implode("`, `", array('CRoomTypes` as `CRT'));
		$CRType = dataselect($tables);
		while ($row = $CRType->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'>";
			$data1 .= "<td contenteditable='true'>".$row[1]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'EditCRT".$row[0]."' style='width:100%;' onclick = editButton(this,'CRoomTypes');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelCRT".$row[0]."' style='width:100%;' onclick = delButton(this,'CRoomTypes');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица индексов профессиоанальных компетенций на странице datacompet.php		
	function PCCode_Table(){
		global $db;
		$data1 = "";
		$tables = implode("`, `", array('PCCode'));
		$PCCode = dataselect($tables);
		while ($row = $PCCode->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td contenteditable='true'>".$row[1]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'EditCR".$row[0]."' style='width:100%;' onclick = editButton(this,'PCCode');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelCR".$row[0]."' style='width:100%;' onclick = delButton(this,'PCCode');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица типов учебных дисциплин на странице datasubj.php		
	function SubjTypes_Table(){
		global $db;
		$data1 = "";
		$tables = implode("`, `", array('SubjTypes'));
		$SType = dataselect($tables);
		while ($row = $SType->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td contenteditable='true'>".$row[1]."</td>";
			$data1 .= "<td contenteditable='true'>".$row[2]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'EditST".$row[0]."' style='width:100%;' onclick = editButton(this,'SubjTypes');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelST".$row[0]."' style='width:100%;' onclick = delButton(this,'SubjTypes');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
//таблица индексов учебных дисциплин на странице datasubj.php
	function SubjCodes_Table(){
		global $db;
		$data1 = '<table id = "SubjCodeTable" style = "border: 4px solid black;"><tr><th class = "CODECOL">Код (для редактирования - 1 клик)</th><th>Содержание</th><th class = "BUTTCOLL">Операции</th></tr>';
		$fields = implode("`, `", array('SC`.`idSubjcode', 'SC`.`subj_code', 'ST`.`STypeName', 'SC`.`idSubjType'));
		$tables = implode("`, `", array('SubjCode` as `SC', 'SubjTypes` as `ST'));
		$w[] = $db->parse("SC.idSubjType = ?s", $_POST['idSubjType']);
		$w[] = $db->parse("SC.idSubjType = ST.idSubjType");
		$SubjCode = dataselect($tables, $w, $fields);
		while ($row = $SubjCode->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td contenteditable='true'>".$row[1]."</td>";
			$data1 .= "<td id = '".$row[3]."'>".$row[2]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' style='width:100%;' id = 'EditSCode".$row[0]."' onclick = editButton(this,'SubjCode');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelSCode".$row[0]."' style='width:100%;' onclick = delButton(this,'SubjCode');>Удалить</button></td></tr>";
		}
		$data1.="</table>";
		echo $data1;
	}
//выпадающие списки при двойном нажатии по ячейке в таблице
//выпадающий список предметов специальности в таблице предметов специальности на странице dataspec.php
	function Subject_Select(){
		global $db;
		$data1 = "<select id='subjsel'>";
		$fields = implode("`, `", array('S`.`idSubject', 'S`.`SubjName'));
		$tables = implode("`, `", array('Subject` as `S', 'SubjTypes` as `ST'));
		$w[] = $db->parse("S.idSubjType = ST.idSubjType");
		$w[] = $db->parse("S.idSubjType = (select idSubjType from SubjCode where idSubjcode ='".$_POST['idSC']."')");
		$Subject = dataselect($tables, $w, $fields);
		while ($row = $Subject->fetch_array()) {
			if ($row[0]==$_POST['idSubject']){
				$data1 .="<option id='".$row[0]."' style='width:300px;' value = '".$row[0]."' selected>".$row[1]."</option>";
			}
			else{$data1 .= "<option id = '".$row[0]."' style='width:300px;' value = '".$row[0]."'>".$row[1]."</option>";}
		}
		$data1 .="</select>";
		echo $data1;
	}
//выпадающий список методов и оценок на странице datacompet.php
	function ContMark_Select(){
		global $db;
		$data1 = "<select id='cmsel' style='width: 150px;'>";
		$tables = implode("`, `", array('ControlMarks'));
		$ContMark =dataselect($tables);
		while ($row = $ContMark->fetch_array()) {
			if ($row[0]==$_POST['idContMark']){
				$data1 .="<option id='".$row[0]."' style='width:400px;' value = '".$row[0]."' selected>".$row[1]."</option>";
			}
			else{$data1 .= "<option id = '".$row[0]."' style='width:400px;' value = '".$row[0]."'>".$row[1]."</option>";}
		}
		$data1 .="</select>";
		echo $data1;
	}
//выпадающий список типов учебных дисциплин на странице datasubj.php
	function SType_Select(){
		global $db;
		$data1 = "<select id='stsel' style='width: 150px;'>";
		$tables = implode("`, `", array('SubjTypes'));
		$SubjType = dataselect($tables);
		while ($row = $SubjType->fetch_array()) {
			if ($row[0]==$_POST['idSubjType']){
				$data1 .="<option id='".$row[0]."' style='width:400px;' value = '".$row[0]."' selected>".$row[1]."</option>";
			}
			else{$data1 .= "<option id = '".$row[0]."' style='width:400px;' value = '".$row[0]."'>".$row[1]."</option>";}
		}
		$data1 .="</select>";
		echo $data1;
	}
//выпадающий список групп пользователей на странице datauser.php
	function Role_Select(){
		global $db;
		$data1 = "";
		$tables = implode("`, `", array('UserRoles'));
		$Roles = dataselect($tables);
		while ($row = $Roles->fetch_array()) {
			$data1 .= "<option id = '".$row[0]."' style='width:200px;' value = '".$row[0]."'>".$row[1]."</option>";
		}
		echo $data1;
	}
//получение кода и наименования специальности
	function getSpecialty($idSpecialty){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('S`.`SpecCode', 'S`.`SpecName'));
		$tables = implode("`, `", array('Specialty` as `S'));
		$w[] = $db->parse("S.idSpecialty = ?s", $idSpecialty);
		$Specialty = dataselect($tables, $w, $fields);
		while ($row = $Specialty->fetch_array()) {
			$data1 .= $row[0]." ".$row[1];
		}
		echo $data1;
	}
//получение индекса и наименования дисциплины
	function getSubject($idSuSp){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('subj_code', 'SubjName'));
		$tables = implode("`, `", array('Subject` as `Su',  'Subj_Spec` as `SS', 'SubjCode` as `SC'));
		$w[] = $db->parse("SS.idSuSp = ?s", $idSuSp);
		$w[] = $db->parse("SS.idSubject = Su.idSubject");
		$w[] = $db->parse("SS.idSubjcode = SC.idSubjcode");
		$Subject = dataselect($tables, $w, $fields);
		while ($row = $Subject->fetch_array()) {
			$data1 .= $row[0]." ".$row[1];
		}
		echo $data1;
	}
//получение типа дисциплины специальности
	function getSuSpType($idSuSp){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('ST`.`idSubjType'));
		$tables = implode("`, `", array('Subject` as `Su',  'Subj_Spec` as `SS', 'SubjTypes` as `ST'));
		$w[] = $db->parse("SS.idSuSp = ?s", $idSuSp);
		$w[] = $db->parse("SS.idSubject = Su.idSubject");
		$w[] = $db->parse("Su.idSubjType = ST.idSubjType");
		$Subject = dataselect($tables, $w, $fields);
		while ($row = $Subject->fetch_array()) {
			$data1 .= $row[0];
		}
		return $data1;
	}
	
	function PractEx_Table1($idSuSp){
		global $db;
		$data1 = "";
		$fields = implode("`, `", array('SPX`.`idSuPrEx', 'PX`.`PractExCont'));
		$tables = implode("`, `", array('PractEx` as `PX', 'Subj_PractEx` as `SPX', 'Subj_Spec` as `SS'));
			$w[] = $db->parse("SPX.idSuSp = SS.idSuSp");
			$w[] = $db->parse("SPX.idPractEx = PX.idPractEx");
			$w[] = $db->parse("SPX.idSuSp = ?s", $idSuSp);
		$PractEx = dataselect($tables, $w, $fields);
		while ($row = $PractEx->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."'><td>".$row[1]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' id = 'DelPX".$row[0]."' style='width:100%;' onclick = delButton(this,'Subj_PractEx');>Удалить</button></td></tr>";
		}
		echo $data1;
	}
	
	//практический опыт для проф модулей
	function PractEx_Table(){
		global $db;
		$data1 = '<table id = "PractExTable" style = "border: 4px solid black;"><tr><th>Содержание (для редактирования - 1 клик)</th><th class = "BUTTCOLL">Операции</th></tr>';
		$tables = implode("`, `", array('PractEx` as `PX'));
		$w[] = $db->parse("PX.idSubject = ?s", $_POST['idSubject']);
		$PractEx = dataselect($tables, $w);
		while ($row = $PractEx->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."' class = 'CODECOL'><td contenteditable='true'>".$row[1]."</td>";
			$data1 .= "<td class = 'BUTTCOLL'><button class = 'btn btn-primary' style='width:100%;' id = 'EditPX".$row[0]."' onclick = editButton(this,'PractEx');>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' style='width:100%;' id = 'DelPX".$row[0]."' onclick = delButton(this,'PractEx');>Удалить</button></td></tr>";
		}
		$data1.="</table>";
		echo $data1;
	}
	
	//выпадающий список групп пользователей в таблице пользователей на странице datauser.php
	function Role_TableSelect(){
		global $db;
		$data1 = "<select id='rolesel'>";
		$tables = implode("`, `", array('UserRoles` as `UR'));
		$Role = dataselect($tables);
		while ($row = $Role->fetch_array()) {
			if ($row[0]==$_POST['idRole']){
				$data1 .="<option id='".$row[0]."' style='width:150px;' value = '".$row[0]."' selected>".$row[1]."</option>";
			}else{
				$data1 .= "<option id = '".$row[0]."' style='width:150px;' value = '".$row[0]."'>".$row[1]."</option>";
				}
		}
		$data1 .="</select>";
		echo $data1;
	}
	
	if(!empty($_POST['func'])){
		switch($_POST['func']){
			case 5:
				Subject_Select();
				break;
			case 10:
				PractEx_Table();
				break;
			case 12:
				CR_Table2();
				break;
			case 15:
				ContMark_Select();
				break;
			case 17:
				SubjCodes_Table();
				break;
			case 18:
				NewSubject_Table();
				break;
			case 19:
				Knowledges_Table();
				break;
			case 20:
				Skills_Table();
				break;
			case 21:
				SType_Select();
				break;
			case 22:
				Role_TableSelect();
				break;
		}
	}	
	
	//выбор функций для выборки данных при загрузке страниц
	
	if(!empty($_POST['funcquer'])){
		switch($_POST['funcquer']) {
			case 1:
				echo Spec_select();
				break;
			case 2:
				echo CRT_select();
				break;
			case 3:
				echo PCCode_select();
				break;
			case 4:
				echo SubjType_select();
				break;
			case 5:
				echo GComp_checkbox();
				break;
			case 6:
				echo Spec_Table();
				break;
			case 7:
				echo ContMark_Select1();
				break;
		}
	}
	
	
	
	
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


//функция получения типа подготовки и установки правильного окончания слов
function Training($var){
	if( $var == 0 ){
		$str = "ая подготовка";
	}else{
		$str = "ой подготовки";
	}
	if( $_POST['training'] == "Базовая подготовка" ){
		return "базов".$str;
	}else{
		return "углубленн".$str;
	}
}

//функция печати нескольких однотипных параграфов
function Print_Paragraph($counter, $stop, $array, $areaText, $styleText){
	while ( $counter <= $stop ){
		$p = new Paragraph( $areaText );
		$p -> addText( $array[$counter], $styleText );
		$counter++;
	}
}
	
//функции по выборке данных для шаблона рабочей программы
function select_all($table_name) {
	global $db;
		$res = $db->query("select * from ".$table_name);
		while ($row = $res->fetch_array()) {
			$arr[] = $row[1];
		}
		return $arr;
}
	
	
	
	
	
	
	
//Функции по выборке данных при загрузке страниц
	function Spec_select() {
		$data1 = "<option id = '0' value = 'empty' selected>--Выбрать специальность--</option>";
		global $db;
		$res = $db->query("SELECT * from Specialty;");
		while ($row = $res->fetch_array()) {
			$data1 .= "<option id='".$row[0]."' value ='".$row[1]." ".$row[2]."'>".$row[1]." ".$row[2]."</option>";
		}
		return $data1;
	}

	function CRT_select() {
		$data1 = "<option id = '0' value = 'empty' selected>--Выбрать тип помещений--</option>";
		global $db;
		$res = $db->query("SELECT * from CRoomTypes;");
		while ($row = $res->fetch_array()) {
			$data1 .= "<option id='".$row[0]."' value ='".$row[1]."'>".$row[1]."</option>";
		}
		return $data1;
	}

	function PCCode_select(){
		$data1 = "<option id = '0' value = 'empty' selected>--Выбрать код компетенции--</option>";
		global $db;
		$pcc_query = $db->query("SELECT * from PCCode ORDER BY idPCCode;");
		while ($pccode = $pcc_query->fetch_array()) {
			$data1 .= "<option id='".$pccode[0]."' value ='".$pccode[1]."'>".$pccode[1]."</option>";
		}
		return $data1;
	}
		
	function SubjType_select(){
		$data1 = "<option value = 'empty' selected>--Выбрать тип дисциплины--</option>";
		global $db;
		$res = $db->query("SELECT * from SubjTypes;");
		while ($row = $res->fetch_array()) {
			$data1 .= "<option id='".$row[0]."' value ='".$row[1]."'>".$row[1]." (".$row[2].")</option>";
		}
		return $data1;
	}
	
	function GComp_checkbox(){
		$data1 = "";
		global $db;
		$res = $db->query("SELECT * from GenComp where idGenComp NOT IN (SELECT idGenComp FROM GC_Spec where idSpecialty = '".$_POST['idSpec']."');");
		while ($row = $res->fetch_array()) {
			$data1 .= "<input type=checkbox id='".$row[0]."' class = 'GCcheck'>".$row[1]." ".$row[2]."<br>";
		}
		return $data1;
	}
	
	function Spec_Table(){
		$data1 = "<table class = 'table table-bordered' id = 'Specialties' ><tr><th>ID</th><th>Код (для редактирования - 1 клик)</th><th>Название (для редактирования - 1 клик)</th><th>Операции</th></tr>";
		global $db;
		$res = $db->query("SELECT * from Specialty;");
		while ($row = $res->fetch_array()) {
			$data1 .= "<tr id = '".$row[0]."'><td>".$row[0]."</td>";
			$data1 .= "<td contenteditable='true'>".$row[1]."</td>";
			$data1 .= "<td contenteditable='true'>".$row[2]."</td>";
			$data1 .= "<td><button class = 'btn btn-primary' id = 'EditSpec".$row[0]."' onclick = editButton(this,'Specialty'); style = 'width:100%;'>Изменить</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'EditDataSpec".$row[0]."' onclick = editDataspec(this); style = 'width:100%;'>Наборы специальности</button><br>";
			$data1 .= "<button class = 'btn btn-primary' id = 'DelSpec".$row[0]."' onclick = delButton(this,'Specialty'); style = 'width:100%;'>Удалить</button></td></tr>";
		}
		$data1 .= "</table>";
		return $data1;
	}

	function ContMark_Select1(){
		$data1 = "<option value = 'empty' selected>--Выбрать контроль и оценку ОК--</option>";
		global $db;
		$res = $db->query("SELECT * from ControlMarks;");
		while ($row = $res->fetch_array()) {
			$data1 .= "<option id='".$row[0]."' value ='".$row[1]."'>".$row[1]."</option>";
		}
		return $data1;
	}
?>
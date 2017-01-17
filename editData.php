<?php
	//ini_set('display_errors',1);
	//error_reporting(E_ALL);
	header('Content-Type: text/html; charset=utf-8, true');
	include './classes/safemysql.class.php';
	
	$db = new SafeMysql();
	
	$data = json_decode($_POST['jsonData'], true); //преобразование приходящих данных в массив $data
	
	function strip($value){
		return strip_tags($value);
	}
	
	//функция запросов на изменений или удаление данных из базы данных
	function updFunc($tab, $fieldArr, $condition){
		global $db;
		global $data;
		$function = $data['function'];
		$where = "WHERE ".implode(' AND ', $condition);
		//$fields = array_map("strip", $fieldArr);
		if($function == 'edit'){
			$sql = "UPDATE ?n SET ?u ?p";
			$Edit = $db->query($sql, $tab, $fieldArr, $where);
			//$Edit = $db->query($sql, $tab, $fields, $where);
			$answer = "Данные изменены!";
			
		}
		else if($function == 'del'){
			$sql = "DELETE FROM ?n ?p";
			$Delete = $db->query($sql, $tab, $where);
			$answer = "Данные удалены";
		}
		echo $answer;
	}
//сбор необходимых данных для запроса изменения или удаления
	function switchTable(){
		global $db;
		global $data;
	
		$allowed = array();
		$w = array();
			switch($data['table']){
				case 'Specialty':
					$allowed = array('SpecCode', 'SpecName');
					$w[] = $db->parse("idSpecialty = ?s", $data['id']);
					break;
				case 'Subject':
					$allowed = array('SubjName', 'idSubjType');
					$w[] = $db->parse("idSubject = ?s", $data['id']);
					break;
				case 'ProfComp':
					$allowed = array('PCompCont', 'idSpecialty', 'idPCCode', 'idContMark');
					$w[] = $db->parse("idPComp = ?s", $data['id']);
					break;
				case 'GenComp':
					$allowed = array('GCompCode', 'GCompCont', 'idContMark');
					$w[] = $db->parse("idGenComp = ?s", $data['id']);
					break;
				case 'Classrooms':
					$allowed = array('CRoom', 'idCRoomType');
					$w[] = $db->parse("idCRoom = ?s", $data['id']);
					break;
				case 'CRoomTypes':
					$allowed = array('CRoomType');
					$w[] = $db->parse("idCRoomType = ?s", $data['id']);
					break;
				case 'CRoom_Spec':
					$allowed = array('idSpecialty', 'idCRoom');
					$w[] = $db->parse("idCRS = ?s", $data['id']);
					break;
				case 'Subj_Spec':
					$allowed = array('idSubjcode', 'idSubject', 'idSpecialty');
					$w[] = $db->parse("idSuSp = ?s", $data['id']);
					break;
				case 'Skills':
					$allowed = array('SkillCont', 'idSubject');
					$w[] = $db->parse("idSkills = ?s", $data['id']);
					break;
				case 'PractEx':
					$allowed = array('PractExCont', 'idSubject');
					$w[] = $db->parse("idPractEx = ?s", $data['id']);
					break;
				case 'Knowledge':
					$allowed = array('KnowCont', 'idSubject');
					$w[] = $db->parse("idKnowledge = ?s", $data['id']);
					break;
				case 'Subj_Skill':
					$allowed = array('idSuSp', 'idSkills');
					$w[] = $db->parse("idSuSk = ?s", $data['id']);
					break;
				case 'Subj_Knowledge':
					$allowed = array('idSuSp', 'idKnowledge');
					$w[] = $db->parse("idSuKn = ?s", $data['id']);
					break;
				case 'Subj_PractEx':
					$allowed = array('idSuSp', 'idPractEx');
					$w[] = $db->parse("idSuPrEx = ?s", $data['id']);
					break;
				case 'GC_Spec':
					$allowed = array('idGenComp', 'idSpecialty');
					$w[] = $db->parse("idGCompSpec = ?s", $data['id']);
					break;
				case 'Subj_PComp':
					$allowed = array('idSuSp', 'idPComp');
					$w[] = $db->parse("idSPC = ?s", $data['id']);
					break;
				case 'Subj_GComp':
					$allowed = array('idSuSp', 'idGenComp');
					$w[] = $db->parse("idSGC = ?s", $data['id']);
					break;
				case 'SubjTypes':
					$allowed = array('STypeCode', 'STypeName');
					$w[] = $db->parse("idSubjType = ?s", $data['id']);
					break;
				case 'SubjCode':
					$allowed = array('subj_code', 'idSubjType');
					$w[] = $db->parse("idSubjcode = ?s", $data['id']);
					break;
				case 'PCCode':
					$allowed = array('PCompCode');
					$w[] = $db->parse("idPCCode = ?s", $data['id']);
					break;
				case 'users':
					$allowed = array('FName', 'LName', 'PName', 'idRole');
					$w[] = $db->parse("id = ?s", $data['id']);
					break;
			}
		$fields = $db->filterArray($data, $allowed);
		updFunc($data['table'], $fields, $w);
	}
	
	if($data['table']){
		switchTable();
	}
?>
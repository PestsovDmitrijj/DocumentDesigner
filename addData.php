<?php
	header('Content-Type: text/html; charset=utf-8, true');
	include_once './classes/safemysql.class.php';
	
	$db = new SafeMysql();
	$data = json_decode($_POST['jsonData'], true); //преобразование приходящих данных в массив $data
	$table = $data['table'];
//функция запроса вставки данных в базу данных
	function insertInto($tab, $allow){
		global $db;
		$check = 0;
		foreach($allow as $item){
			if(empty($item)){ 
				$check = 1;
				break;	
			}
		}
		if ($check == 1){
			echo "Введены пустые значения!";
		}else{
			$allow_lenght = count($allow);
			for($i=0;$i<$allow_lenght;$i++){
				$db->query("INSERT INTO ?n values (?a)", $tab, $allow[$i]);
			}
				echo "Данные успешно записаны в таблицу ".$tab."!";
				
		}
	}
//функция сбора нужных для запроса данных
	function switchTable($tab1){
		global $data;
		if(!empty($data)){
			@$spec = $data['spec'];
			@$croom = $data['croom'];
			@$subject = $data['disc'];
			@$stcode = $data['subjcode'];
			@$subjcode = $data['subjcode'];
			@$speccode = $data['speccode'];
			@$pccode = $data['pccode'];
			@$gccode = $data['gccode'];
			@$susp = $data['susp'];
			@$pc = $data['pc'];
			@$gc = $data['gc'];
			@$skill = $data['skill'];
			@$knowledge = $data['knowledge'];
			@$practex = $data['practex'];
			@$roomtype = $data['roomtype'];
			@$stype = $data['stype'];
			@$idContMark = $data['idcontmark'];
			@$alloweds = array();
			@$pc_lenght = count($pc);
			@$skill_lenght = count($skill);
			@$knowledge_lenght = count($knowledge);
			@$practex_lenght = count($practex);
			@$gc_lenght = count(@$gc);
			@$croom_lenght = count($croom);
		}
		switch ($tab1) {
			case "Skills":
				array_push($alloweds, array('NULL', $skill, $subject));
				break;
			case "ProfComp":
				array_push($alloweds, array('NULL', $pc, $spec, $pccode, $idContMark));
				break;
			case 'Subj_Spec':
				array_push($alloweds, array('NULL', $subjcode, $subject, $spec));
				break;
			case 'Subj_PComp':
				for($i=0;$i<$pc_lenght;$i++){
					array_push($alloweds, array('NULL', $susp,  $pc[$i]));
				}
				break;
			case 'Subj_Skill':
				for($i=0;$i<$skill_lenght;$i++){
					array_push($alloweds, array('NULL', $susp,  $skill[$i]));
				}
				break;
			case 'Subj_Knowledge':
				for($i=0;$i<$knowledge_lenght;$i++){
					array_push($alloweds, array('NULL', $susp,  $knowledge[$i]));
				}
				break;
			case 'Subj_PractEx':
				for($i=0;$i<$practex_lenght;$i++){
					array_push($alloweds, array('NULL', $susp,  $practex[$i]));
				}
				break;
			case 'Subj_GComp':
				for($i=0;$i<$gc_lenght;$i++){
					array_push($alloweds, array('NULL', $susp,  $gc[$i]));
				}
				break;
			case "CRoomTypes":
				array_push($alloweds, array('NULL', $roomtype));
				break;
			case "Classrooms":
				array_push($alloweds, array('NULL', $croom, $roomtype));
				break;
			case "CRoom_Spec":
				for($i=0;$i<$croom_lenght;$i++){
					array_push($alloweds, array('NULL', $spec, $croom[$i]));
				}
				break;
			case "GC_Spec":
				for($i=0;$i<$gc_lenght;$i++){
					array_push($alloweds, array('NULL', $gc[$i], $spec));
				}
				break;
			case "GenComp":
				array_push($alloweds, array('NULL', $gccode, $gc, $idContMark));
				break;
			case "PCCode":
				array_push($alloweds, array('NULL', $pccode));
				break;
			case "Specialty":
				array_push($alloweds, array('NULL', $speccode, $spec));
				break;
			case "SubjTypes":
				array_push($alloweds, array('NULL', $stcode, $stype));
				break;
			case "Subject":
				array_push($alloweds, array('NULL', $subject, $stype));
				break;
			case "SubjCode":
				array_push($alloweds, array('NULL', $subjcode, $stype));
				break;
			case "Knowledge":
				array_push($alloweds, array('NULL', $knowledge, $subject));
				break;
			case "PractEx":
				array_push($alloweds, array('NULL', $practex, $subject));
				break;
		}
		insertInto($tab1, $alloweds);
	}
	
	switchTable($table);
?>
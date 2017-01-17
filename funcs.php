<?php

//include_once('connect.php');

// Костыли-костылики
function addBlankLines($count) {
	for ($i = 0; $i < $count; $i++) {
	$p = new Paragraph();
	$p->addText("");
	}
}

/* function getPCParagraph($disc, $spec) {
	global $mysqli;
	$PC = $mysqli->query("SELECT PCC.PCompCode, PC.PCompCont FROM ProfComp as PC, PCCode as PCC, Subj_PComp as SP, Subj_Spec as SS
		where SP.idSuSp = SS.idSuSp
		and SS.idSuSp = '".$disc."'
		and PC.idSpecialty = '".$spec."'
		and SP.idPComp = PC.idPComp
		and PCC.idPCCode = PC.idPCCode;");
	while ($row = $PC->fetch_array()) {
		$p = new Paragraph($jstText);
		$p->addText($row[0]." ", $frt);
		$p->addText($row[1], $frt);
	}
}

function getGCParagraph($disc, $spec) {
	global $mysqli;
	$GenComp = $mysqli->query("SELECT GC.idGenComp, GC.GCompCode, GC.GCompCont FROM GenComp as GC, Subj_GComp as SGC, Subj_Spec as SS
				where SGC.idSuSp = SS.idSuSp
				and SS.idSuSp = '".$disc."'
				and SGC.idGenComp = GC.idGenComp;");
	while ($row = $GenComp->fetch_array()) {
		$p = new Paragraph($jstText);
		$p->addText($row[1]." ", $frt);
		$p->addText($row[2], $frt);
	}
} */


?>
$(document.body).ready(function(){
	$('#newTem, #newSod, #newPrakt, #newLabor, #newSamPrakt, #newSamTeor').prop("disabled", true);
	$(".specclass").ready(function() {
		$.ajax({
			type: "POST",				
			url: "getData.php",
			data: 'funcquer=1',
			cache: false,
			success: function(data){
				$(".specclass").html(data);
			}
		});
		
	});
	
	function receiveData(fd,blockarr){
		$.ajax({
			url: 'getData.php',
			type:'POST',
			data:'jsonData=' + $.toJSON(fd),
			cache: false,
			success: function(data){
				//alert(data);
				var mass = JSON.parse(data);
				for(var i=0; i<blockarr.length; i++){
					document.getElementById(blockarr[i]).innerHTML = mass[i];
				}
			}
		});
	}
	
	$('#specialty4').change(function() {
		var spec = $('#specialty4 option:selected').attr('id');
		var func = [1, 3];
		var formData = {"spec":spec,"func":func};
		var blocks = ["SubjSpec", "crooms"];
		receiveData(formData,blocks);
	});
	
	$('#SubjSpec').change(function() {
		var spec = $('#specialty4 option:selected').attr('id');
		var disc = $('#SubjSpec option:selected').attr('id');
		var func = [2, 5, 6, 7];
		var formData = {"spec":spec,"disc":disc,"func":func};
		var blocks = ["PCompBlock", "SkillBlock", "KnowledgeBlock", "GCompBlock"];
		receiveData(formData,blocks);
	});
	
	$('#attestation').change(function() {
		var spec = $('#specialty4 option:selected').attr('id');
		var func = [1];
		var formData = {"spec":spec,"func":func};
		var idAtt = $('#attestation option:selected').attr('id');
		var blocks = ["attestation2"];
		if ((idAtt == 4) || (idAtt == 5))  {
			receiveData(formData,blocks);
			$("#attestation2").prop("hidden", false);
		} else {
			$("#attestation2").html('');
			$("#attestation2").prop("hidden", true);
		}
	});

});
	var numRazd, numTem, numHours, numCont, numEqLab, numEqTso, numEqUm;
	var locNumTem, locNumSod, locNumPrakt, locNumLabor, locNumSamPrakt, locNumSamTeor;
	var numLvl, numSod, numPrakt, numLabor, numSamPrakt, numSamTeor;
	var addHeaderPrakr, addHeaderLabor, addHeaderSamPrakt, addHeaderSamTeor;
	var sumSod = sumPrakt = sumLabor = sumSamPrakt = sumSamTeor = 0;
	numRazd = numTem = numHours = numCont = 0;
	locNumTem = locNumSod = locNumPrakt = locNumLabor = locNumSamPrakt = locNumSamTeor= 0;
	numLvl = numSod = numPrakt = numLabor = numSamPrakt = numSamTeor = numEqLab = numEqTso = numEqUm = 0;
	numOLit = numDLit = removedTem = removedRazd = 0;
	addHeaderPrakr = addHeaderLabor = addHeaderSamPrakt = addHeaderSamTeor = true;
	
	/*function rm(e) {
		var table = $('#TemPlan');
		obj = $(e);
		//alert(obj);
		table.removeChild(obj);
	}*/
	
	function checkMaxRow(n) {
		if (document.getElementById('maxNumRow').value < n) {
			document.getElementById('maxNumRow').value = n;
		}
	}
	
	function rmTemPlan(type, idChild, n) {
		switch(type){
			case("razd"):
				//$('#'+idChild+""+n).remove();
				$("tr[id^='razd"+n+"']").each(function() {$(this).remove();});
				$('#newTem, #newSod, #newPrakt, #newLabor, #newSamPrakt, #newSamTeor').prop("disabled", true);
				$('#newRazd').prop("disabled", false);
				removedRazd++;
			break;
			
			case("tem"):
				//$('#'+idChild+""+n).remove();
				$("tr[id^='"+idChild+""+n+"']").each(function() {$(this).remove();});
				$('#newSod, #newPrakt, #newLabor, #newSamPrakt, #newSamTeor').prop("disabled", true);
				$('#newTem, #newRazd').prop("disabled", false);
				removedTem++;
			break;
			
			case("remAllRow"):
				$("tr[id^='"+idChild+"']").each(function() {$(this).remove();});
			break;
			
			default:
				$('#'+idChild).remove();
			break;
		}
		$('#submit').prop("disabled", true);		
	}
	
	
	//===========================================
	// * Добавление нового раздела в таблицу
	//===========================================
	function addRazd() {
		numRazd++;
		numTem = 0;
		var TD1 = "<tr id=razd"+numRazd+"><td style='text-align:center; background-color:#ffffff'> Раздел "+numRazd+": </td>"
			+"<td><input required id = 'nameRazd"+numRazd+"' name = 'nameRazd"+numRazd+"' style='width:100%' /></td>"
			+"<td colspan = 1 style = 'background-color:#ffffff'></td>"
			+"<td><input required id = 'hourRazd"+numRazd+"' name = 'hourRazd"+numRazd+"' style='width:100%' /></td>"
			+"<td colspan = 1 style = 'background-color:#ffffff'></td>"
			+ "<td><button title = 'Удалить весь раздел' id = 'remRazd' disabled type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('razd','','"+numRazd+"')>"
			+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
		$('#TemPlan tbody').append(TD1);
		$('#newTem').prop("disabled", false);
		$('#newRazd, #newSod, #newPrakt, #newLabor, #newSam, #submit, #checkHours, #newSamPrakt, #newSamTeor').prop("disabled", true);
		locNumTem = 1;
		checkMaxRow(numRazd);
	}
	
	//===========================================
	// * Добавление новой темы в таблицу
	//===========================================
	function addTem() {
		numTem++;
		numHours++;
		numCont++;
		numLvl++;
		var TD2 = "<tr id = 'razd"+numRazd+"Tem"+locNumTem+"'><td style='text-align:right; background-color:#ffffff'>Тема "+(numRazd)+"."+locNumTem+": </td>"
			+"<td><input required id = 'nameTem"+locNumTem+"Razd"+numRazd+"' name = 'nameTem"+locNumTem+"Razd"+numRazd+"' style='width:100%' /></td>"
			+"<td colspan = 1 style = 'background-color:#ffffff'></td>"
			+"<td><input required id = 'hoursTem"+locNumTem+"Razd"+numRazd+"' name = 'hoursTem"+locNumTem+"Razd"+numRazd+"' style='width:100%' /></td>"
			+"<td colspan = 1 style = 'background-color:#ffffff'></td>"
			+"<td><button title = 'Удалить всю тему' id = 'remTem' disabled type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('tem','razd"+numRazd+"Tem','"+locNumTem+"')>"
			+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
		var TD3 = "<tr id = 'razd"+numRazd+"Tem"+locNumTem+"SodHead'><td colspan = 1 style = 'background-color:#ffffff'></td>"
		//===========================================
		// * После добавления темы, необходимо заполнить содержание,
		// * создаём соответствующий заголовок
		//===========================================
			+"<td colspan = 2 style = 'background-color:#ffffff;'>Содержание учебного материала</td>"
			+"<td colspan = 1 style = 'background-color:#ffffff'>↑</td><td colspan = 1 style = 'background-color:#ffffff'></td>"
			+"<td><button title = 'Удалить содержание целиком' disabled id = 'remDef' type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('remAllRow','razd"+numRazd+"Tem"+numTem+"Sod','"+locNumTem+"')>"
			+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
		//===========================================
		// * Нельзя создавать новые темы, разделы или добавлять в
		// * существующую тему работы, если нет хотя бы одного 
		// * элемента в содержании
		//===========================================
		$('#TemPlan').append(TD2+TD3);
		$('#newSod').prop("disabled", false);
		$('#newRazd, #newTem, #newPrakt, #newLabor, #newSamPrakt, #newSamTeor, #submit, #checkHours').prop("disabled", true);
		locNumTem++;
		locNumSod = locNumPrakt = locNumLabor = locNumSamPrakt = locNumSamTeor = 1;
		addHeaderPrakr = addHeaderLabor = addHeaderSamPrakt = addHeaderSamTeor = true;
		checkMaxRow(numTem);
	}
	//===========================================
	// * Добавление элемента в содержание учебного материала
	//===========================================
	function addSod() {
		numSod++;
		var TD4 = "<tr id = 'razd"+numRazd+"Tem"
			+numTem+"Sod"+locNumSod+"'><td colspan = 1 style = 'background-color:#ffffff'></td>"
			+"<td colspan = 1 style = 'background-color:#ffffff; text-align:right'>"+locNumSod+".</td>"
			+"<td><input required id = 'contSod"
				+locNumSod+"Tem"+numTem+"Razd"+numRazd
				+"' name = 'contSod"+locNumSod+"Tem"
				+numTem+"Razd"+numRazd+"' style='width:100%' /></td>"
			+"<td><input required id = 'hoursSod"
				+locNumSod+"Tem"+numTem+"Razd"
				+numRazd+"'  name = 'hoursSod"
				+locNumSod+"Tem"+numTem+"Razd"
				+numRazd+"' style='width:100%' /></td>"
			+"<td><input required id = 'lvlSod"
				+locNumSod+"Tem"+numTem+"Razd"
				+numRazd+"' name = 'lvlSod"
				+locNumSod+"Tem"+numTem+"Razd"
				+numRazd+"' style='width:100%' /></td>"
			+"<td><button id = 'remDef' type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('default','razd"
				+numRazd+"Tem"+numTem+"Sod"+locNumSod+"','"+locNumTem+"')>"
			+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
		$('#TemPlan').append(TD4);
		//===========================================
		// * После добавления содержания, становится возможным
		// * добавлять в тему лабораторные и практические работы 
		//===========================================
		$('#submit').prop("disabled", true);
		$('#newPrakt, #newLabor, #newSamPrakt, #newSamTeor, #newTem, #newRazd, #checkHours, #remRazd, #remTem, #remDef').prop("disabled", false);
		locNumSod++;
		checkMaxRow(numSod);
	}
	//===========================================
	// * Добавление практической работы. Полная аналогия с 
	// * добавлением лабораторной работы
	//===========================================
	function addPrakt() {
		numPrakt++;
		if (addHeaderPrakr == true) {
			var TD5 = "<tr id = 'razd"+numRazd+"Tem"+numTem+"Prakt"+numPrakt+"Head'><td colspan = 1 style = 'background-color:#ffffff'></td>"
				+"<td colspan = 2 style = 'background-color:#ffffff;'>Практические работы:</td>"
				+"<td><input required id = 'hoursPraktTem"+numTem+"Razd"+numRazd+"' name = 'hoursPraktTem"+numTem+"Razd"+numRazd+"' style = 'width:100%' /></td>"
				+"<td style = 'background-color:#ffffff'></td>"
				+"<td><button title = 'Удалить все практические работы' id = 'remDef' type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('remAllRow','razd"+numRazd+"Tem"+numTem+"Prakt','"+locNumTem+"')>"
				+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
			$('#TemPlan').append(TD5);
			addHeaderPrakr = false;
		}
		var TD6 = "<tr id = 'razd"+numRazd+"Tem"+numTem+"Prakt"+numPrakt+"'><td colspan = 1 style = 'background-color:#ffffff'></td>"
			+"<td colspan = 1 style = 'background-color:#ffffff; text-align:right'>"+locNumPrakt+".</td>"
			+"<td><input required id = 'contPrakt"+locNumPrakt+"Tem"+numTem+"Razd"+numRazd+"' name = 'contPrakt"+locNumPrakt+"Tem"+numTem+"Razd"+numRazd+"' style='width:100%' /></td>"
			+"<td colspan = 2 style = 'background-color:#ffffff'></td>"
			+"<td><button id = 'remDef' type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('default','razd"+numRazd+"Tem"+numTem+"Prakt"+locNumPrakt+"','"+locNumTem+"')>"
			+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
		$('#TemPlan').append(TD6);
		$('#submit').prop("disabled", true);
		$('#newTem, #newRazd, #checkHours').prop("disabled", false);
		locNumPrakt++;
		checkMaxRow(numPrakt);
	}

	//===========================================
	// * Добавление лабораторной работы
	//===========================================
	function addLabor() {
		numLabor++;
		//===========================================
		// * Если добавляемая работа первая, то создаётся строка с 
		// * указанием, что далее будут лабораторные работы
		//===========================================
		if (addHeaderLabor == true) {
			var TD7 = "<tr id = 'razd"+numRazd+"Tem"+numTem+"Labor"+numLabor+"Head'><td colspan = 1 style = 'background-color:#ffffff'></td>"
				+"<td colspan = 2 style = 'background-color:#ffffff;'>Лабораторные работы:</td>"
				+"<td> <input required id = 'hoursLaborTem"+numTem+"Razd"+numRazd+"' name = 'hoursLaborTem"+numTem+"Razd"+numRazd+"' style = 'width:100%'> </td>"
				+"<td style = 'background-color:#ffffff'></td>"
				+"<td><button title = 'Удалить все лабораторные работы' id = 'remDef' type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('remAllRow','razd"+numRazd+"Tem"+numTem+"Labor','"+locNumTem+"')>"
			+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
			$('#TemPlan').append(TD7);
			addHeaderLabor = false;
		}
		//===========================================
		// * Добавление полей ввода для лабораторной работы
		//===========================================
		var TD8 = "<tr id = 'razd"+numRazd+"Tem"+numTem+"Labor"+numLabor+"'><td colspan = 1 style = 'background-color:#ffffff'></td>"
			+"<td colspan = 1 style = 'background-color:#ffffff; text-align:right'>"+locNumLabor+".</td>"
			+"<td><input required id = 'contLabor"+locNumLabor+"Tem"+numTem+"Razd"+numRazd+"' name = 'contLabor"+locNumLabor+"Tem"+numTem+"Razd"+numRazd+"' style='width:100%' /></td>"
			+"</td><td colspan = 2 style = 'background-color:#ffffff'></td>"
			+"<td><button id = 'remDef' type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('default','razd"+numRazd+"Tem"+numTem+"Labor"+locNumLabor+"','"+locNumTem+"')>"
			+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
		$('#TemPlan').append(TD8);
		//===========================================
		// * Как только в тему добавлена лабораторная или
		// * практическая работа, можно проверить введённые данные и
		// добавлять новые темы или разделы
		//===========================================
		$('#submit').prop("disabled", true);
		$('#newTem, #newRazd, #checkHours').prop("disabled", false);
		locNumLabor++;
		checkMaxRow(numLabor);
	}
	
	//===========================================
	// * Добавление самостоятельной работы
	//===========================================
	function addSamPrakt() {
		numSamPrakt++;
		//===========================================
		// * Если добавляемая работа первая, то создаётся строка с 
		// * указанием, что далее будут самостоятельные работы
		//===========================================
		if (addHeaderSamPrakt == true) {
			var TD9 = "<tr id = 'razd"+numRazd+"Tem"+numTem+"SamPrakt"+numSamPrakt+"Head'><td colspan = 1 style = 'background-color:#ffffff'></td>"
				+"<td colspan = 2 style = 'background-color:#ffffff;'>Самостоятельная работа обучающихся (практическая часть):</td>"
				+"<td colspan = 2 style = 'background-color:#ffffff'></td>"
				+"<td><button title = 'Удалить все самостоятельные работы' id = 'remDef' type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('remAllRow','razd"+numRazd+"Tem"+numTem+"SamPrakt','"+locNumTem+"')>"
			+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
			$('#TemPlan').append(TD9);
			addHeaderSamPrakt = false;
		}
		//===========================================
		// * Добавление полей ввода для самостоятельной работы
		//===========================================
		TD10 = "<tr id = 'razd"+numRazd+"Tem"+numTem+"SamPrakt"+numSamPrakt+"'><td colspan = 1 style = 'background-color:#ffffff'></td>"
			+"<td colspan = 1 style = 'background-color:#ffffff; text-align:right'>"+locNumSamPrakt+".</td>"
			+"<td><input required id = 'contSamPrakt"+locNumSamPrakt+"Tem"+numTem+"Razd"+numRazd+"' name = 'contSamPrakt"+locNumSamPrakt+"Tem"+numTem+"Razd"+numRazd+"' style='width:100%' /></td>"
			+"<td><input required id = 'hoursSamPrakt"+locNumSamPrakt+"Tem"+numTem+"Razd"+numRazd+"' name = 'hoursSamPrakt"+locNumSamPrakt+"Tem"+numTem+"Razd"+numRazd+"' style='width:100%'></td>"
			+"<td colspan = 1 style = 'background-color:#ffffff'></td>"
			+"<td><button id = 'remDef' type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('default','razd"+numRazd+"Tem"+numTem+"SamPrakt"+numSamPrakt+"','"+locNumTem+"')>"
			+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
		$('#TemPlan').append(TD10);
		//===========================================
		// * Как только в тему добавлена  работа, можно проверить
		// *	введённые данные и добавлять новые темы или разделы
		//===========================================
		$('#submit').prop("disabled", true);
		$('#newTem, #newRazd, #checkHours').prop("disabled", false);
		locNumSamPrakt++;
		checkMaxRow(numSamPrakt);
	}
	
	function addSamTeor() {
		numSamTeor++;
		//===========================================
		// * Если добавляемая работа первая, то создаётся строка с 
		// * указанием, что далее будут самостоятельные работы
		//===========================================
		if (addHeaderSamTeor == true) {
			var TD9 = "<tr id = 'razd"+numRazd+"Tem"+numTem+"SamTeor"+numSamTeor+"Head'><td colspan = 1 style = 'background-color:#ffffff'></td>"
				+"<td colspan = 2 style = 'background-color:#ffffff;'>Самостоятельная работа обучающихся (теоретическая часть):</td>"
				+"<td colspan = 2 style = 'background-color:#ffffff'></td>"
				+"<td><button title = 'удалить все самостоятельные работы' id = 'remDef' type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('remAllRow','razd"+numRazd+"Tem"+numTem+"SamTeor','"+locNumTem+"')>"
			+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
			$('#TemPlan').append(TD9);
			addHeaderSamTeor = false;
		}
		//===========================================
		// * Добавление полей ввода для самостоятельной работы
		//===========================================
		TD10 = "<tr id = 'razd"+numRazd+"Tem"+numTem+"SamTeor"+numSamTeor+"'><td colspan = 1 style = 'background-color:#ffffff'></td>"
			+"<td colspan = 1 style = 'background-color:#ffffff; text-align:right'>"+locNumSamTeor+".</td>"
			+"<td><input required id = 'contSamTeor"+locNumSamTeor+"Tem"+numTem+"Razd"+numRazd+"' name = 'contSamTeor"+locNumSamTeor+"Tem"+numTem+"Razd"+numRazd+"' style='width:100%' /></td>"
			+"<td><input required id = 'hoursSamTeor"+locNumSamTeor+"Tem"+numTem+"Razd"+numRazd+"' name = 'hoursSamTeor"+locNumSamTeor+"Tem"+numTem+"Razd"+numRazd+"' style='width:100%'></td>"
			+"<td colspan = 1 style = 'background-color:#ffffff'></td>"
			+"<td><button id = 'remDef' type = button class = 'btn btn-danger' style = 'width:100%' onClick = rmTemPlan('default','razd"+numRazd+"Tem"+numTem+"SamTeor"+numSamTeor+"','"+locNumTem+"')>"
			+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
		$('#TemPlan').append(TD10);
		//===========================================
		// * Как только в тему добавлена  работа, можно проверить
		// *	введённые данные и добавлять новые темы или разделы
		//===========================================
		$('#submit').prop("disabled", true);
		$('#newTem, #newRazd, #checkHours').prop("disabled", false);
		locNumSamTeor++;
		checkMaxRow(numSamTeor);
	}
	
	//===========================================
	// * Проверка введённых данных
	//===========================================
	function agree() {
		var notMatch = false;
		var sumAll, hoursTem, hoursRazd, id;
		var color;
		$('#errBlock').html(" ");
		razdCount = $('[id^=nameRazd]').length;
		razdCount += removedRazd;
		sumAll = hoursTem = hoursRazd = id = 0
		//===========================================
		// * Проверка совпадения часов (раздел-темы)
		//===========================================
		//===========================================
		// * Проходим по всем разделам
		//===========================================
		for (i = 1; i<razdCount+1; i++) {
			$('#hourRazd'+i).each(function(){hoursRazd += parseInt(this.value);});
			var TemCount = $('[id$=Razd'+i+']').filter($('[id^=nameTem]')).length;
			TemCount += removedTem;
				//===========================================
				// * Проходим по всем темам в текущем разделе. Если кол-во
				// * часов не совпадает, выводится сообщение с указанием
				// * раздела, в котором часы не совпадают
				//===========================================
			for (j = 1;j<TemCount+1; j++) {
				$('#hoursTem'+j+'Razd'+i).each(function(){
					if ($("tr").is("#razd"+i+"Tem"+j)) {
						hoursTem += parseInt(this.value);
						//alert (hoursTem);
					}
				});
			}
			if (hoursRazd != hoursTem) {
				if (isNaN(hoursRazd)) {
					hoursRazd = '(есть незаполненные поля)';
				}
				if (isNaN(hoursTem)) {
					hoursTem = '(есть незаполненные поля)';
				}
				$('#errBlock').addClass("alert alert-danger");
				$('#errBlock').html('Не совпадает объём часов в разделе '+i+"<br>"
						+'Указано часов всего: ' + hoursRazd + ', всего часов в темах: ' + hoursTem + '<hr>');
				hoursTem = hoursRazd = 0;
				$('#hourRazd'+i).css("background-color", "#FFC9C7");
				for (j = 1; j<TemCount+1; j++) {
					$('#hoursTem'+j+'Razd'+i).each(function() {$(this).css("background-color", "#FFC9C7");});
				}
				notMatch = true;
			} else {
					sumAll += hoursRazd;
					hoursTem = hoursRazd = 0;
					$('#hourRazd'+i).css("background-color", "#CBFFCB");
					for (j = 1; j<TemCount+1; j++) {
					$('#hoursTem'+j+'Razd'+i).each(function() {$(this).css("background-color", "#CBFFCB");});
					}
				}
		}
		
		//===========================================
		// * Проверка совпадения объёма часов внутри темы
		//===========================================
		
		hoursSod = hoursPrakt = hoursLabor = hoursSamPrakt = hoursSamTeor = 0;
		
		//===========================================
		// * Проходит по всем разделам, внутри каждого раздела по всем
		// * темам, внутри темы по всем работам. Если сумма часов 
		// * внутри темы не совпадает с указанной пользователем
		// * суммой, то выводится сообщение об ошике с указанием на
		// * место ошибки
		//===========================================
		for (i = 1;i<razdCount+1; i++) {
			if ($('#hourRazd'+i)) {
			TemCount = $('[id$=Razd'+i+']').filter($('[id^=nameTem]')).length;
			TemCount += removedTem;
				for (j = 1;j<=TemCount; j++) {
					//if ($("#nameTem"+j+"Razd"+i) && $("tr").is("#nameTem"+j+"Razd"+i)) {
					if ($("tr").is("#razd"+i+"Tem"+j)) {
						//alert ($("#nameTem"+j+"Razd"+i));
						//===========================================
						// * Ищет сумму всех часов, указанных в содержании, 
						// * в практических, лабораторных, самостоятельных
						//===========================================
						$('[id^=hoursSod]').filter($('[id$=Tem'+j+'Razd'+i+']')).each(function() {hoursSod += parseInt(this.value);});
						$("#hoursPraktTem"+j+"Razd"+i).each(function() {hoursPrakt += parseInt(this.value);});		
						$("#hoursLaborTem"+j+"Razd"+i).each(function() {hoursLabor += parseInt(this.value);});
						$('[id^=hoursSamPrakt]').filter($('[id$=Tem'+j+'Razd'+i+']')).each(function() {hoursSamPrakt += parseInt(this.value);});
						$('[id^=hoursSamTeor]').filter($('[id$=Tem'+j+'Razd'+i+']')).each(function() {hoursSamTeor += parseInt(this.value);});
						//===========================================
						// * Если сумма всех часов, указанных в работах и 
						// * содержании не совпадает с максимальной нагрузкой
						// * в теме, то подкрашивает тему в красный цвет и 
						// * сообщает об ошибке. Если всё совпадает -- в зелёный
						//===========================================
						sum = hoursSod+hoursPrakt+hoursLabor+hoursSamPrakt+hoursSamTeor;
						if ($("#hoursTem"+j+"Razd"+i).val() != sum) {
							if ( ($("#hoursTem"+j+"Razd"+i).val() == '') || isNaN($("#hoursTem"+j+"Razd"+i).val()) ) {
								$("#hoursTem"+j+"Razd"+i).val(0);
							}
							if (isNaN(sum)) {
								sum = '(есть незаполненные поля)';
							}
							$('#errBlock').addClass("alert alert-danger");
							$('#errBlock').append("Не совпадает объём часов в теме "+j+", раздела "+i+":<br>"
								+"Указано часов всего: " + $("#hoursTem"+j+"Razd"+i).val()+", "
								+"Получившаяся сумма работ: " + sum + "<hr>");
							notMatch = true;
							
							color = "#FFC9C7";
							sum = 0;
						} else {
							color = "#CBFFCB";
							sum = 0;
						}
						hoursSod = hoursPrakt = hoursLabor = hoursSamPrakt = hoursSamTeor = 0;
							$('#hoursTem'+j+'Razd'+i).each(function() {$(this).css("background-color", color);});
							$('#hoursPraktTem'+j+'Razd'+i).each(function() {$(this).css("background-color", color);});
							$('#hoursLaborTem'+j+'Razd'+i).each(function() {$(this).css("background-color", color);});
							$('[id^=hoursSamPrakt]').filter($('[id$=Tem'+j+'Razd'+i+']')).each(function() {$(this).css("background-color", color);});
							$('[id^=hoursSamTeor]').filter($('[id$=Tem'+j+'Razd'+i+']')).each(function() {$(this).css("background-color", color);});
							$('[id^=hoursSod]').filter($('[id$=Tem'+j+'Razd'+i+']')).each(function() {$(this).css("background-color", color);});	
					} 
				}
			} 
		}
		
		//===========================================
		// * Если никаких ошибок нет -- кнопка создания документа
		// * становится доступной
		//===========================================
		$('#submit').prop("disabled", notMatch);
		if (notMatch == false) {
			sumSod = sumPrakt = sumLabor = sumSamPrakt = sumSamTeor = 0;
			$('#razdCount').val(razdCount);
			$('#errBlock').removeClass("alert alert-danger");
			$('#errBlock').addClass("alert alert-success");
			$('#errBlock').html("<strong>Максимальная учебная нагрузка:</strong> " + sumAll + "ч.");
			$('#sumAll').val(sumAll);
			for (i = 1;i<razdCount+1; i++) {
				if ($('#hourRazd'+i)) {
				TemCount = $('[id$=Razd'+i+']').filter($('[id^=nameTem]')).length;
					for (j = 1;j<=TemCount; j++) {
						if ($("#nameTem"+j+"Razd"+i)) {
							$('#hoursPraktTem'+j+'Razd'+i).each(function() {sumPrakt+=parseInt($(this).val());});
							$('#hoursLaborTem'+j+'Razd'+i).each(function() {sumLabor+=parseInt($(this).val());});
							$('[id^=hoursSamPrakt]').filter($('[id$=Tem'+j+'Razd'+i+']')).each(function() {sumSamPrakt+=parseInt($(this).val());});
							$('[id^=hoursSamTeor]').filter($('[id$=Tem'+j+'Razd'+i+']')).each(function() {sumSamTeor+=parseInt($(this).val());});
							$('[id^=hoursSod]').filter($('[id$=Tem'+j+'Razd'+i+']')).each(function() {sumSod+=parseInt($(this).val());});		
							$('#sumPrakt').val(sumPrakt);
							$('#sumLabor').val(sumLabor);
							$('#sumSod').val(sumSod);
							$('#sumSamPrakt').val(sumSamPrakt);		
							$('#sumSamTeor').val(sumSamTeor);		
						}
					}
				}
			}
		} else {
			$('#errBlock').append("<p> Исправьте ошибки, чтобы продолжить </p>");
		}
	}

	
		/*function doccreate(){
			for (var j = 1;j<razdCount+1; j++) {
				var TemCount = $('[id$=Razd'+j+']').filter($('[id^=nameTem]')).length;
				for (var i = 1;i<TemCount+1; i++) {
					var nameRazd = $("#nameRazd"+j).val();
					var hoursTem = $("#hoursTem"+locNumTem+"Razd"+numRazd).val();
					var nameTem = $("#nameTem"+locNumTem+"Razd"+numRazd).val();
					var contSod = $("#contSod"+locNumSod+"Tem"+numTem+"Razd"+numRazd).val();
					var hoursSod = $("#hoursSod"+locNumSod+"Tem"+numTem+"Razd"+numRazd).val();
					var hoursPrakt = $("#hoursPraktTem"+numTem+"Razd"+numRazd).val();
					var contPrakt = $("#contPrakt"+locNumPrakt+"Tem"+numTem+"Razd"+numRazd).val();
					var hoursLabor = $("#hoursLaborTem"+numTem+"Razd"+numRazd).val();
					var contLabor = $("#contLabor"+locNumLabor+"Tem"+numTem+"Razd"+numRazd).val();
					var contSam = $("#contSam"+locNumSam+"Tem"+numTem+"Razd"+numRazd).val();
					var hoursSam = $("#hoursSam"+locNumSam+"Tem"+numTem+"Razd"+numRazd).val();
					$.ajax({
						type: "POST",				
						url: "index.php?nameRazd="+nameRazd+"&hoursTem="+hoursTem+"&nameTem="+nameTem+"&contSod="+contSod,
						cache: false,
						success: function(data){
							alert("Передано!");
						}
					});
				}
			}
		}*/
	
	function rm(idChild) {
		$('#'+idChild).remove();
	}
	
	function addEqRow(idTable, nameRow) {
		//alert (idTable + ":" + nameRow);
		var n = 0;
		switch(nameRow) {
			case('eqLab'):
			numEqLab++;
			n = numEqLab;
			document.getElementById('countEqLab').value = n;
			//alert(document.getElementById('countEqUm').value);
			break;
			
			case('tso'):
			numEqTso++;
			n = numEqTso;
			document.getElementById('countEqTso').value = n;
			//alert(document.getElementById('countEqUm').value);
			break;
			
			case('um'):
			numEqUm++;
			n = numEqUm;
			document.getElementById('countEqUm').value = n;
			//alert(document.getElementById('countEqUm').value);
			break;
			
			case('eqMas'):
			numEqLab++;
			n = numEqLab;
			document.getElementById('countEqMas').value = n;
			//alert(document.getElementById('countEqUm').value);
			break;
			
			case('OLit'):
			numOLit++;
			n = numOLit;
			document.getElementById('countOLit').value = n;
			//alert(document.getElementById('countEqUm').value);
			break;
			
			case('DLit'):
			numDLit++;
			n = numDLit;
			document.getElementById('countDLit').value = n;
			//alert(document.getElementById('countEqUm').value);
			break;
		}
		//table = document.getElementById(idTable);
		var TD = "<tr  id = '"+nameRow+""+n+"'>"
				+"<td><input required style = 'width:100%' name = '"+nameRow+""+n+"'> </td>"
				+"<td><button type = button class = 'btn btn-danger' style = 'width:100%' onClick = rm('"+nameRow+""+n+"')>"
				+ "<i class='fa fa-times' aria-hidden='true'></i></button></td></tr>";
			$('#'+idTable).append(TD);
	}
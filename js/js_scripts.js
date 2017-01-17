
	var spec, disc, susp, croom, pc, gc, skill, knowledge, speccode, subjcode, pccode, gccode, roomtype, stype, subjtype;
	var func, formData, blocks;
//Функция отправки запроса на  добавление данных	
	function sendData(fd) {
		var checkEmpty = 0;
		$.each(fd, function(key, val){
			if(!val || val==0){
				checkEmpty++;
			}
		});
		if (checkEmpty>0){
				alert("Отсутствует "+checkEmpty+" значения!");
		}else{
			$.ajax({
				url:'addData.php',
				type:'POST',
				data:'jsonData=' + $.toJSON(fd),
				success: function(data) {
					$('#messageBlock').html(data);
					$("#messageBlock").fadeIn();
					$("#messageBlock").fadeOut(3500);
					//alert(data);
				}
			});
		}
	}
//Сбор необходимых данных для отправки запроса на сервер	 
	function switchData(id){
		switch(id){
//SubjTypes
			case 'addSubjTypeButt': 
				subjcode = $('#STCodeText').val();
				stype = $('#SubjTypeText').val();
				formData = {"table":"SubjTypes","subjcode":subjcode,"stype":stype};
				break;
 //Subject
			case 'SubjectButt':
				disc = $('#Subjecttext').val();
				stype = $("#STCode1 option:selected").attr('id');
				formData = {"table":"Subject","disc":disc,"stype":stype};
				break;
//SubjCode
			case 'addSubjCodeButt': 
				subjcode = $('#SubjCodetext').val();
				stype = $("#STCode option:selected").attr('id');
				formData = {"table":"SubjCode","subjcode":subjcode,"stype":stype};
				break;
//Knowledge
			case 'KnowButt': 
				disc = $("#Subject1 option:selected").attr('id');
				knowledge = $('#Knowledge1').val();
				formData = {"table":"Knowledge","disc":disc,"knowledge":knowledge};
				break;
//Skills
			case 'SkillButt': 
				disc = $("#Subject1 option:selected").attr('id');
				skill = $('#Skill1').val();
				formData = {"table":"Skills","disc":disc,"skill":skill};
				break;
//PractEx
			case 'PractExButt': 
				disc = $("#Subject1 option:selected").attr('id');
				practex = $('#PractEx1').val();
				formData = {"table":"PractEx","disc":disc,"practex":practex};
				break;
//Specialty
			case 'addSpecialtyButt': 
				spec = $("#textSpec").val();
				speccode = $("#textSpecCode").val();
				divContent = "#EditSpecForm";
				formData = {"table":"Specialty","speccode":speccode,"spec":spec};
				break;
//ProfComp
			case 'PCompButton':
				pccode = $("#PC option:selected").attr('id');
				pc = $('#textPC').val();
				spec = $('#specialty').val();
				formData = {"table":"ProfComp","pccode":pccode,"pc":pc,"spec":spec, "idcontmark":1};
				break;
//GC_Spec
			case 'GCompButton':
				gc = $('.GCcheck').map(function(i,el){
					if($(el).prop('checked')){
						return $(el).attr('id');
					}
				}).get();
				spec = $('#specialty').val();
				formData = {"table":"GC_Spec","gc":gc,"spec":spec};
				break;
//CRoom_Spec
			case 'SCRoomsButton':
				croom = $('.CRoomcheck').map(function(i,el){
					if($(el).prop('checked')){
						return $(el).attr('id');
					}
					}).get();
				spec = $('#specialty').val();
				formData = {"table":"CRoom_Spec","croom":croom,"spec":spec};
				break;
//Subj_Spec
			case 'addSubjectButton':
				disc = $("#Subject1 option:selected").attr('id');
				subjcode = $("#scode option:selected").attr('id');
				spec = $('#specialty').val();
				formData = {"table":"Subj_Spec","disc":disc,"subjcode":subjcode,"spec":spec};
				break;
//Subj_GComp
			case 'GCForm2Button':
				gc = $('.GCcheckbox1').map(function(i,el){
						if($(el).prop('checked')){
							return $(el).attr('id');
						}
					}).get();
				susp = $("#subject").val();
				formData = {"table":"Subj_GComp","gc":gc,"susp":susp};
				break;
//Subj_PComp
			case 'PCForm2Button':
				pc = $('.PCcheckbox1').map(function(i,el){
						if($(el).prop('checked')){
							return $(el).attr('id');
						}
					}).get();
				susp = $("#subject").val();
				formData = {"table":"Subj_PComp","pc":pc,"susp":susp};
				break;
//Subj_Knowledge
			case 'KnowFormButton':
				knowledge = $('.Knowcheckbox1').map(function(i,el){
						if($(el).prop('checked')){
							return $(el).attr('id');
						}
					}).get();
				susp = $("#subject").val();
				formData = {"table":"Subj_Knowledge","knowledge":knowledge,"susp":susp};
				break;
//Subj_Skill
			case 'SkillFormButton':
				skill = $('.Skillcheckbox1').map(function(i,el){
					if($(el).prop('checked')){
						return $(el).attr('id');
					}
					}).get();
				susp = $("#subject").val();
				formData = {"table":"Subj_Skill","skill":skill,"susp":susp};
				break;
//Subj_Skill
			case 'PractExFormButton':
				practex = $('.PractExCheckbox1').map(function(i,el){
					if($(el).prop('checked')){
						return $(el).attr('id');
					}
					}).get();
				susp = $("#subject").val();
				formData = {"table":"Subj_PractEx","practex":practex,"susp":susp};
				break;
//CRoomTypes
			case 'CRTButton':
				roomtype = $("#CRTtext").val();
				formData = {"table":"CRoomTypes","roomtype":roomtype};
				break;
//Classrooms
			case 'CRButton':
				roomtype = $("#CRType1 option:selected").attr('id');
				croom = $("#CRoomtext").val();
				formData = {"table":"Classrooms","roomtype":roomtype,"croom":croom};
				break;
//GenComp
			case 'addGenCompButt':
				gccode = $('#GCCodetext').val();
				gc = $('#GCtext').val();
				idContMark = $('.conmarksel option:selected').attr('id');
				formData = {"table":"GenComp","gccode":gccode,"gc":gc,"idcontmark":idContMark};
				break;
//PCCode
			case 'addPCCodeButt':
				pccode = $('#PCCodetext').val();
				formData = {"table":"PCCode","pccode":pccode};
				break;
		}
		sendData(formData);
	}
//Функция отправки запроса на выборку данных 
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
					var element = document.getElementById(blockarr[i]);
					if(element){
						element.innerHTML = mass[i];
					}
				}
			}
		});
	}	
//Сбор необходимых даных для запроса на выборку данных
	function switchOnChange(id){
		switch(id){
			case 'susp':
				spec = $('#specialty').val();
				susp = $('#subject').val();
				func = [7,2,6,5,8];
				formData = {"spec":spec,"susp":susp, "func":func};
				blocks = ["GCompBlock2", "PCompBlock", "KnowledgeBlock", "SkillBlock", "PractExBlock"];
				break;
			case 'subjtype':
				subjtype = $("#subjtype option:selected").attr('id');
				func = [1, 4];
				formData = {"subjtype":subjtype,"func":func};
				blocks = ["Subject1", "scode"];
				break;
			case 'CRType2':
				roomtype = $('#CRType2 option:selected').attr('id');
				func = [3];
				formData = {"roomtype":roomtype,"func":func};
				blocks = ["SCRooms"];
				break;
		}
		receiveData(formData,blocks);
	}
//Функция отправки запроса на выборку данных при загрузке страницы	
	function onReady(func,element){
		var idSpec = $('#specialty').val();
		$.ajax({
			type: "POST",				
			url: "getData.php",
			data: 'funcquer='+func+'&idSpec='+idSpec,
			cache: false,
			success: function(data){
				$(''+element+'').html(data);
			}
		});
	}
//Сбор данных для запроса на выборку данных при загрузке страницы
	$(window).load(function(){
		if($('.specclass').length){
			func = 1;
			var element = ".specclass";
			onReady(func,element);
		}
		if($('.CRTclass').length){
			func = 2;
			var element = ".CRTclass";
			onReady(func,element);
		}
		if($('.pcclass').length){
			func = 3;
			var element = ".pcclass";
			onReady(func,element);
		}
		if($('.subjtypeclass').length){
			func = 4;
			var element = ".subjtypeclass";
			onReady(func,element);
		}
		if($('#GCompBlock1').length){
			func = 5;
			var element = "#GCompBlock1";
			onReady(func,element);
		}
		if($('#EditSpecForm').length){
			func = 6;
			var element = "#EditSpecForm";
			onReady(func, element);
		}
		if($('.conmarksel').length){
			func = 7;
			var element = '.conmarksel';
			onReady(func, element);
		}
	});
//Функция отправки запроса на удалеие или изменение данных	
	function DelEditData(fd){
		$.ajax({
			type: "POST",				
			url: "editData.php",
			data: 'jsonData=' + $.toJSON(fd),
			cache: false,
			success: function(data){
				$('#messageBlock').html(data);
				$("#messageBlock").fadeIn();
				$("#messageBlock").fadeOut(3500);
			}
		});
	}
//Сбор необходимых данных для запроса на изименение данных	
	function editButton(Button, table){
		var parentrow = Button.parentNode.parentNode,
		idSpec = $('#specialty').val(),
		id = Button.parentNode.parentNode.id;
		switch(table){
			case 'Specialty':
				var codespec = parentrow.getElementsByTagName("td")[1].innerHTML,
				namespec = parentrow.getElementsByTagName("td")[2].innerHTML,
				formData = {"id":id,"SpecCode":codespec,"SpecName":namespec,"function":"edit","table":table};
				break;
			case 'Subj_Spec':
				var idSubjcode = parentrow.childNodes[0].childNodes[1].value;
				if(parentrow.childNodes[1].childNodes[1] === undefined){
					var selected = parentrow.childNodes[1].childNodes[0].options.selectedIndex;
					var  idSubject = parentrow.childNodes[1].childNodes[0].options[selected].id;
				}
				else{
					var idSubject = parentrow.childNodes[1].childNodes[1].value;
				}
				formData = {"id":id,"idSubjcode":idSubjcode,"idSpecialty":idSpec,"idSubject":idSubject,"function":"edit","table":table};
				break;
			case 'ProfComp':
				var PCompCont = parentrow.getElementsByTagName("td")[1].innerHTML,
				idPCCode = parentrow.getElementsByTagName("td")[0].id,
				formData = {"id":id,"idPCCode":idPCCode,"idSpecialty":idSpec,"PCompCont":PCompCont,"idContMark":"1","function":"edit","table":table};
				break;
			case 'CRoomTypes':
				var CRoomType = parentrow.getElementsByTagName("td")[0].innerHTML,
				formData = {"id":id,"CRoomType":CRoomType,"function":"edit","table":table};
				break;
			case 'Classrooms':
				var CRoom = parentrow.getElementsByTagName("td")[1].innerHTML,
				idCRType = $('#CRType1 option:selected').attr('id');
				formData = {"id":id,"CRoom":CRoom,"idCRoomType":idCRType,"function":"edit","table":table};
				break;
			case 'GenComp':
				var GCompCode = parentrow.getElementsByTagName("td")[0].innerHTML,
				GCompCont = parentrow.getElementsByTagName("td")[1].innerHTML;
				
				if(parentrow.childNodes[2].childNodes[1] === undefined){
					var idContMark = $('#cmsel option:selected').attr('id');
				}
				else{
					idContMark = parentrow.childNodes[2].childNodes[1].value;
				}
				
				formData = {"id":id,"GCompCode":GCompCode,"GCompCont":GCompCont,"idContMark":idContMark,"function":"edit","table":table};
				break;
			case 'PCCode':
				var PCCode = parentrow.getElementsByTagName("td")[0].innerHTML,
				formData = {"id":id,"PCompCode":PCCode,"function":"edit","table":table};
				break;
			case 'SubjTypes':
				var STypeCode = parentrow.getElementsByTagName("td")[0].innerHTML,
				STypeName = parentrow.getElementsByTagName("td")[1].innerHTML,
				formData = {"id":id,"STypeCode":STypeCode,"STypeName":STypeName,"function":"edit","table":table};
				break;
			case 'SubjCode':
				var subj_code = parentrow.getElementsByTagName("td")[0].innerHTML,
				idSubjType = parentrow.getElementsByTagName("td")[1].id,
				formData = {"id":id,"subj_code":subj_code,"idSubjType":idSubjType,"function":"edit","table":table};
				break;
			case 'Subject':
				var SubjName = parentrow.getElementsByTagName("td")[0].innerHTML;
				if(parentrow.childNodes[1].childNodes[1] === undefined){
					var selected = parentrow.childNodes[1].childNodes[0].options.selectedIndex;
					var  idSubjType = parentrow.childNodes[1].childNodes[0].options[selected].id;
				}
				else{
					idSubjType = parentrow.childNodes[1].childNodes[1].value;
				}
				
				formData = {"id":id,"SubjName":SubjName,"idSubjType":idSubjType,"function":"edit","table":table};
				break;
			case 'Skills':
				var SkillCont = parentrow.getElementsByTagName("td")[0].innerHTML,
				idSubject = $('#Subject1 option:selected').attr('id'),
				formData = {"id":id,"SkillCont":SkillCont,"idSubject":idSubject,"function":"edit","table":table};
				break;
			case 'Knowledge':
				var KnowCont = parentrow.getElementsByTagName("td")[0].innerHTML,
				idSubject = $('#Subject1 option:selected').attr('id'),
				formData = {"id":id,"KnowCont":KnowCont,"idSubject":idSubject,"function":"edit","table":table};
				break;
			case 'PractEx':
				var PractExCont = parentrow.getElementsByTagName("td")[0].innerHTML,
				idSubject = $('#Subject1 option:selected').attr('id'),
				formData = {"id":id,"PractExCont":PractExCont,"idSubject":idSubject,"function":"edit","table":table};
				break;
			case 'users':
				var FName = parentrow.getElementsByTagName("td")[2].innerHTML,
				LName = parentrow.getElementsByTagName("td")[3].innerHTML,
				PName = parentrow.getElementsByTagName("td")[4].innerHTML;
				if(parentrow.childNodes[5].childNodes[1] === undefined){
					var selected = parentrow.childNodes[5].childNodes[0].options.selectedIndex;
					var  idRole = parentrow.childNodes[5].childNodes[0].options[selected].id;
				}
				else{
					idRole = parentrow.childNodes[5].childNodes[1].value;
				}
				
				formData = {"id":id,"FName":FName,"LName":LName,"PName":PName,"idRole":idRole,"function":"edit","table":table};
				break;
		}
		DelEditData(formData);
		//alert(idSubject);
	}
//Сбор необходимых данных для запроса на удаление данных	
	function delButton(Button, table){
		var id = Button.parentNode.parentNode.id;
		formData = {"id":id,"function":"del","table":table};
		DelEditData(formData);
	}
//Функции для перехода на страницы при нажатии на кнопки "Наборы ..."
	function editDataspec(Button){
		var idSpec = Button.parentNode.parentNode.id;
		var url = "dataspec.php?idSpec="+idSpec;
		document.location.href = url;
	}

	function editDatasubj(Button){
		idSpec = $('#specialty').val();
		idSuSp = Button.parentNode.parentNode.id;
		var url = "datasubjspec.php?idSpec="+idSpec+"&idSuSp="+idSuSp;
		document.location.href = url;
	}
	
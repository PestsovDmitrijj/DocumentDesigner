<html>
<head>
<title>Дисциплины</title>
	<meta charset=utf8>
	<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap-theme.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<link rel="stylesheet" href="./vendor/pure-release-0.6.0/pure-min.css">
	<style type="text/css">
		body {
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
			font-family: Arial;
		}
		.BUTTCOL{
			width: 100px;
		}
		#messageBlock{
			/*visibility: hidden;*/
			display: none;
    width:450px;
    height:120px;
    position:fixed;
	z-index:999;
    right:0;
    bottom:0;
		}
	</style>
</head>
<script src="./vendor/jquery-2.0.3.min.js"></script>
<script src="./vendor/jquery.json-1.3.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./js/ajax-form.js"></script>
<script src="./js/js_scripts.js"></script>
<script>
	
$(document.body).ready(function(){
	$('#subjtype').change(function(){
		var idSubjType = $('#subjtype option:selected').attr('id');
		//alert(idSubjType);
		if (idSubjType==5){
			$('#PractExForm').prop("hidden", false);
		}else{
			$('#PractExForm').prop("hidden", true);
		}
	});
		$('#STCode').change(function(){
			idSubjType = $('#STCode option:selected').attr('id');
			$.ajax({
				type: "POST",				
				url: "getData.php",
				data: 'func=17&idSubjType='+idSubjType,
				cache: false,
				success: function(data){
					$('#SubjCodeTable').html(data);
				}
			});
		});
		$('#STCode1').change(function(){
			idSubjType = $('#STCode1 option:selected').attr('id');
			$.ajax({
				type: "POST",				
				url: "getData.php",
				data: 'func=18&idSubjType='+idSubjType,
				cache: false,
				success: function(data){
					$('#Subjects').html(data);
					$('.styperows').dblclick(function(e){
						var elem = this.id;
						var parentrow = this.parentNode,
						idSubjType = parentrow.childNodes[1].childNodes[1].value;
						$.ajax({	
							type: "POST",				
							url: "getData.php",
							data: 'func=21&idSubjType='+idSubjType,
							cache: false,
							success: function(data){
								document.getElementById(elem).innerHTML = data;
							}
						});	
					});
				}
			});	
		});
		$('#Subject1').change(function(){
			idSubject = $('#Subject1 option:selected').attr('id');
			$.ajax({
				type: "POST",				
				url: "getData.php",
				data: 'func=19&idSubject='+idSubject,
				cache: false,
				success: function(data){
					$('#KnowledgeTable').html(data);
				}
			});
		});
		$('#Subject1').change(function(){
			idSubject = $('#Subject1 option:selected').attr('id');
			$.ajax({
				type: "POST",				
				url: "getData.php",
				data: 'func=20&idSubject='+idSubject,
				cache: false,
				success: function(data){
					$('#SkillTable').html(data);
				}
			});
		});
		$('#Subject1').change(function(){
			idSubject = $('#Subject1 option:selected').attr('id');
			$.ajax({
				type: "POST",				
				url: "getData.php",
				data: 'func=10&idSubject='+idSubject,
				cache: false,
				success: function(data){
					$('#PractExTable').html(data);
				}
			});
		});
	});
</script>
<body>
<?php
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
include_once './getData.php';
require_once './classes/Auth.class.php';
?>
<?php if (Auth\User::isAuthorized()): ?>
<?php if ($_SESSION['idRole']==1 || $_SESSION['idRole']==2) : ?>
<div class="container">
<div id = 'messageBlock' class="alert alert-success"></div>
 <h3>Вы авторизованы под учетной записью пользователя <?php echo $_SESSION['username']; ?>.</h3>
	<form class="ajax" method="post" action="./ajax.php">
          <input type="hidden" name="act" value="logout">
          <div class="form-actions">
              <button class="btn btn-large btn-primary" type="submit">Выход</button>
          </div><br>
		  <ul class="nav nav-pills">
			  <li role="nav" class="active"><a href = 'cabinet.php'>Личный кабинет</a></li>
			  <li role="nav"><a href = 'tables.php'>Управление информацией из базы данных</a></li>
			</ul>
    </form>
<h1>Управление данными о дисциплинах</h1>
<hr>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Типы и циклы дисциплин</h3>
		</div>
		<div class="panel-body">
			<div id = 'SubjTypeForm' class = "rows">
				<div class="col-md-5">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Добавление новых типов и циклов учебных дисциплин</h3>
						</div>
						<div class="panel-body">
							<p> Впишите тип и его расишфровку:</p>
							<input id = 'STCodeText' type = 'text' placeholder = 'ОГСЭ' style = "width: 60px;">
							<input id = 'SubjTypeText' type = 'text' placeholder = 'Общий гуманитарный и социально-экономический цикл' style = "width: 390px;">
							<br><br>
							<button id = 'addSubjTypeButt' onclick = switchData(this.id);>Сохранить</button>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Список типов и циклов дисциплин</h3>
						</div>
						<div class="panel-body">
							<table id = "SubjTypeTable" class = 'table table-bordered'><tr><th class = "CODECOL">Код (для редактирования - 1 клик)</th><th>Содержание (для редактирования - 1 клик)</th><th class = 'BUTTCOLL'>Операции</th></tr><?php SubjTypes_Table(); ?></table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Индексы дисциплин</h3>
		</div>
		<div class="panel-body">
			<div id = 'SubjCodeForm' class = "rows">
				<div class="col-md-5">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Добавление новых индексов дисциплин</h3>
						</div>
						<div class="panel-body">
							<p> Выберите тип дисциплины и впишите новый индекс:</p>
							<select id = 'STCode'  class = "subjtypeclass" style = "width: 340px;">
								<option id='0' selected="selected"  value ='empty'>Выбрать тип дисциплины</option>
							</select>
							<input id = 'SubjCodetext' type = 'text' placeholder = 'ОГСЭ.01' style = "width: 340px;">
							<br><br>
							<button id = 'addSubjCodeButt' onclick = switchData(this.id);>Сохранить</button>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Список индексов дисциплин</h3>
						</div>
						<div class="panel-body">
							<table id = "SubjCodeTable" class = 'table table-bordered'><tr><th class = "CODECOL">Код (для редактирования - 1 клик)</th><th>Содержание</th><th class = 'BUTTCOLL'>Операции</th></tr></table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Список дисциплин</h3>
		</div>
		<div class="panel-body">
			<div id = 'NewSubjForm' class = "rows">
				<div class="col-md-5">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Добавление новых учебных дисциплин</h3>
						</div>
						<div class="panel-body">
							<p> Выберите тип дисциплины и впишите ее наименование:</p>
							<select id = 'STCode1'  class = "subjtypeclass" style = "width: 340px;">
								<option id='0' selected="selected" value ='empty'>Выбрать тип дисциплины</option>
							</select>
							<input id = 'Subjecttext' type = 'text' placeholder = 'Основы философии' style = "width: 340px;">
							<br><br>
							<button id = 'SubjectButt' onclick = switchData(this.id);>Сохранить</button>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Список дисциплин</h3>
						</div>
						<div id = 'Subjects' class="panel-body" style = 'height: 600px; overflow: auto;'>
							<table id = "SubjectTable" class = 'table table-bordered'><tr><th class = "CODECOL">Дисциплина (для редактирования - 1 клик)</th><th>Тип дисциплины (для изменения - 2 клика)</th><th class = 'BUTTCOLL'>Операции</th></tr></table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Список знаний и умений</h3>
		</div>
		<div class="panel-body">
			<div id = 'SElDiscForm' class = "rows">
				<div class="col-md-12">
					<div class="panel-body">
						<p> Выберите тип дисциплины:</p>
						<select id = 'subjtype' style="width: 340px" class = "subjtypeclass" onchange = switchOnChange(this.id);>
						</select>
						<p> Выберите дисциплину:</p>
						<select id = 'Subject1'  class = "subject1class" style = "width: 340px;">
							<option value ='empty'>Выбрать дисциплину</option>
						</select>
					</div>
				</div>
			</div>
			
			<div id = 'KnowForm' class = "rows">
				<div class="col-md-5">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Добавление списка знаний для дисциплины</h3>
						</div>
						<div class="panel-body">
							<p> Внести новые знания:</p>
							<textarea id = 'Knowledge1' style = "width: 390px; height: 80px;"></textarea>
							<br><br>
							<button id='KnowButt' onclick = switchData(this.id);>Сохранить</button>
						</div>
					</div>
				</div>
				<div class="col-md-7" style='min-height:300px;'>
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Список знаний</h3>
						</div>
						<div class="panel-body">
							<table id = "KnowledgeTable" class = 'table table-bordered'><tr><th>Содержание (для редактирования - 1 клик)</th><th class = 'BUTTCOLL'>Операции</th></tr></table>
						</div>
					</div>
				</div>	
			</div>
			
			<div id = 'SkillForm' class = "rows">
				<div class="col-md-5">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Добавление списка умений для дисциплины</h3>
						</div>
						<div class="panel-body">
							<p>Внести новые умения:</p>
							<textarea id = 'Skill1' style = "width: 390px; height: 80px;"></textarea>
							<br><br>
							<button id='SkillButt' onclick = switchData(this.id);>Сохранить</button>
						</div>
					</div>
				</div>
				<div class="col-md-7" style='min-height:300px;'>
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Список умений</h3>
						</div>
						<div class="panel-body">
							<table id = "SkillTable" class = 'table table-bordered'><tr><th>Содержание (для редактирования - 1 клик)</th><th class = 'BUTTCOLL'>Операции</th></tr></table>
						</div>
					</div>
				</div>	
			</div>
			
			<div id = 'PractExForm' class = "rows" hidden = true>
				<div class="col-md-5">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Добавление списка практического опыта для профессионального модуля</h3>
						</div>
						<div class="panel-body">
							<p>Внести новый практический опыт:</p>
							<textarea id = 'PractEx1' style = "width: 390px; height: 80px;"></textarea>
							<br><br>
							<button id='PractExButt' onclick = switchData(this.id);>Сохранить</button>
						</div>
					</div>
				</div>
				<div class="col-md-7" style='min-height:300px;'>
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Список практического опыта</h3>
						</div>
						<div class="panel-body">
							<table id = "PractExTable" class = 'table table-bordered'><tr><th>Содержание (для редактирования - 1 клик)</th><th class = 'BUTTCOLL'>Операции</th></tr></table>
						</div>
					</div>
				</div>	
			</div>
			
		</div>
	</div>
</div>
<?php else : header('Location: cabinet.php');?>
<?php endif; ?>
<?php else : header('Location: index.php'); ?>
<?php endif; ?>
</div>
</body>
</html>

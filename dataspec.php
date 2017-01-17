<html>
<head>
	<title>Управление данными специальностей</title>
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
<script src="./vendor/jquery-2.0.3.min.js"></script>
<script src="./vendor/jquery.json-1.3.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./js/ajax-form.js"></script>
<script src="./js/js_scripts.js"></script>
</head>
<?php
$idSpec = $_REQUEST['idSpec'];
include_once './getData.php';
?>
<script>
	$(window).load(function(){
		$('.subjrows').dblclick(function(e){
			var elem = this.id;
			var parentrow = this.parentNode;
			var idSC = parentrow.childNodes[0].childNodes[1].value;
			var idSubject = parentrow.childNodes[1].childNodes[1].value;
			$.ajax({	
				type: "POST",				
				url: "getData.php",
				data: 'func=5&idSC='+idSC+'&idSubject='+idSubject,
				cache: false,
				success: function(data){
					document.getElementById(elem).innerHTML = data;
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
			  <li role="nav"><a href = 'spectables.php'>Список специальностей</a></li>
			</ul>
    </form>
<h1>Управление наборами данных специальности <?php getSpecialty($idSpec); ?></h1>
<hr>
<input hidden id='specialty' value = '<?php echo $idSpec; ?>'></input>
<!--Форма учебных дисциплин-->
<div class="col-md-12">
	<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Учебные дисциплины специальности <?php getSpecialty($idSpec); ?></h3>
			</div>
			<div class="panel-body">
<div id = 'SubjectForm' class = "rows">
	<div class="col-md-5">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Добавление учебных дисциплин в набор специальности</h3>
			</div>
			<div class="panel-body">
				<p> Выберите тип дисциплин:</p>
				<select id = 'subjtype'   class = 'subjtypeclass'  style="width: 300px" onchange = switchOnChange(this.id); autocomplete="off"></select>
				<br><br>
				<p> Выберите код дисциплины:</p>
				<select id = 'scode' class = 'scodeselect' style="width: 110px"> 
					<option id = 0 selected="selected" value = 0 >Код</option>
				</select>
				<p> Выберите наименование дисциплины:</p>
				<select id = 'Subject1' class = "subjselect" style="width: 300px">
					<option id = 0 selected="selected" value = 0>Дисциплина</option>
				</select>
				<br><br>
				<button id="addSubjectButton" onclick = 'switchData(this.id);'>Сохранить</button>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Набор учебных дисциплин специальности <?php getSpecialty($idSpec); ?></h3>
			</div>
			<div class="panel-body" style = 'overflow: auto; height: 600px;'>
					<table id = "SubjectTable" class = 'table table-bordered'><tr><th>Код</th><th>Содержание (для редактирования - 2 клика)</th><th class = 'BUTTCOL'>Операции</th></tr><?php Subject_Table($idSpec); ?></table>
			</div>
		</div>
	</div>
</div>
</div>
		</div>
	</div>
<!--Форма учебных помещений-->
<div class="col-md-12">
	<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Учебные помещения специальности <?php getSpecialty($idSpec); ?></h3>
			</div>
			<div class="panel-body">
<div id = 'CRoomForm' class = "rows">
	<div class="col-md-5">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Добавление учебных помещений в набор специальности</h3>
			</div>
			<div class="panel-body">
				<select id = 'CRType2' style="width: 300px" class = "CRTclass" onchange = switchOnChange(this.id); autocomplete="off"></select>
				<p> Список помещений:</p>
				<div id = "SCRooms"></div>
				<button id="SCRoomsButton" onclick = switchData(this.id);>Сохранить</button>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Набор учебных помещений специальности <?php getSpecialty($idSpec); ?></h3>
			</div>
			<div class="panel-body" style = 'overflow: auto; height: 600px;'>
				<table id = "CRTable" class = 'table table-bordered'><tr><th class = "CODECOL">Код</th><th>Наименование</th><th class = 'BUTTCOLL'>Операции</th></tr><?php CR_Table($idSpec); ?></table>
			</div>
		</div>
	</div>
</div>
</div>
	</div>
</div>
<!--Форма общих компетенций-->
<div class="col-md-12">
	<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Общие компетенции специальности <?php getSpecialty($idSpec); ?></h3>
			</div>
			<div class="panel-body">
	<div id = 'GCForm' class = "rows">
	<div class="col-md-5">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Добавление общих компетенций в набор специальности</h3>
			</div>
			<div class="panel-body">
				<div id = 'GCompBlock1'></div>
				<br>
				<button id="GCompButton" onclick = switchData(this.id);>Сохранить</button>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Набор общих компетенций специальности <?php getSpecialty($idSpec); ?></h3>
			</div>
			<div class="panel-body" style = 'overflow: auto; height: 600px;'>
				<table id = "GCTable" class = 'table table-bordered'><tr><th class = "CODECOL">Код</th><th>Наименование</th><th class = 'BUTTCOLL'>Операции</th></tr><?php GC_Table($idSpec); ?></table>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<!--Форма профессиональных компетенций-->	
	<div class="col-md-12">
	<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Профессиональные компетенции специальности <?php getSpecialty($idSpec); ?></h3>
			</div>
			<div class="panel-body">
			<div id = 'PCForm' class = "rows">
	<div class="col-md-5">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Добавление профессиональных компетенций в набор специальности</h3>
			</div>
			<div class="panel-body">
				<select id = 'PC' class = 'pcclass'></select>
				<p> Впишите содержимое ПК:</p>
				<TEXTAREA style="width:400px; height: 90px;" id="textPC"></TEXTAREA>
				<br><br>
				<button id="PCompButton" onclick = switchData(this.id);>Сохранить</button>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Набор профессиональных компетенций специальности <?php getSpecialty($idSpec); ?></h3>
			</div>
			<div class="panel-body" style = 'overflow: auto; height: 600px;'>
				<table id = "PCTable" class = 'table table-bordered'><tr><th class = "CODECOL">Код</th><th>Содержание (для редактирования - 1 клик)</th><th class = 'BUTTCOLL'>Операции</th></tr><?php PC_Table($idSpec); ?></table>
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

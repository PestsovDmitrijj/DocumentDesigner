<html>
<head>
	<title>Набор дисциплин специальности</title>
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
<?php
$idSpec = $_REQUEST['idSpec'];
$idSuSp = $_REQUEST['idSuSp'];
include_once './getData.php';
?>
<script src="./vendor/jquery-2.0.3.min.js"></script>
<script src="./vendor/jquery.json-1.3.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./js/ajax-form.js"></script>
<script src="./js/js_scripts.js"></script>
<script>
$(window).load(function(){
	var idSpec = <?php echo $idSpec; ?>;
	var idSuSp = <?php echo $idSuSp; ?>;
	$('#specialty').val(idSpec);
	$('#subject').val(idSuSp);
});
</script>
<body onload = switchOnChange("susp");><?php
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';
?>
<?php if (Auth\User::isAuthorized()): ?>
<?php if ($_SESSION['idRole']==1 || $_SESSION['idRole']==2) : ?>
<?php $SuSpType = getSuSpType($idSuSp); ?>
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
			  <li role="nav"><a href = 'dataspec.php?idSpec=<?php echo $idSpec; ?>'>Данные специальности <?php getSpecialty($idSpec); ?></a></li>
			</ul>
    </form>
	<h1>Дисциплина <?php getSubject($idSuSp); ?> <br> Специальность <?php getSpecialty($idSpec); ?></h1>
	<hr>
	<input hidden id='specialty'>
	<input hidden id='subject'>
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
			<?php if ($SuSpType==5) : ?>
				<h3 class="panel-title">Общие компетенции профессионального модуля <?php getSubject($idSuSp); ?>,<br> специальность <?php getSpecialty($idSpec); ?></h3>
			<?php else : ?>
				<h3 class="panel-title">Общие компетенции дисциплины <?php getSubject($idSuSp); ?>,<br> специальность <?php getSpecialty($idSpec); ?></h3>
			<?php endif; ?>
			</div>
			<div class="panel-body">
				<div id = 'GCForm2' class = "rows">
					<div class="col-md-5">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Добавление ОК дисциплинам</h3>
							</div>
							<div class="panel-body">
								<p> Выберите ОК:</p>
								<div id = "GCompBlock2"></div>
								<br>
								<button id = 'GCForm2Button' onclick = switchData(this.id);>Сохранить</button>
							</div>
						</div>
					</div>
					<div class="col-md-7">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Набор ОК дисциплины</h3>
							</div>
							<div class="panel-body">
								<table id = "GCTable2" class = 'table table-bordered'><tr><th class = "CODECOL">Код</th><th>Содержание</th><th class = 'BUTTCOLL'>Операции</th></tr><?php GC_Table2($idSuSp); ?></table>
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
			<?php if ($SuSpType==5) : ?>
				<h3 class="panel-title">Профессиональные компетенции профессионального модуля <?php getSubject($idSuSp); ?>,<br> специальность <?php getSpecialty($idSpec); ?></h3>
			<?php else : ?>
				<h3 class="panel-title">Профессиональные компетенции дисциплины <?php getSubject($idSuSp); ?>,<br> специальность <?php getSpecialty($idSpec); ?></h3>
			<?php endif; ?>
			</div>
			<div class="panel-body">
				<div id = 'PCForm2' class = "rows">
					<div class="col-md-5">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Добавление ПК дисциплинам</h3>
							</div>
							<div class="panel-body">
								<p> Выберите ПК:</p>
								<div id = "PCompBlock"></div>
								<br>
								<button id = 'PCForm2Button' onclick = switchData(this.id);>Сохранить</button>
							</div>
						</div>
					</div>
					<div class="col-md-7">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Набор ПК дисциплины</h3>
							</div>
							<div class="panel-body">
								<table id = "PCTable2" class = 'table table-bordered'><tr><th class = "CODECOL">Код</th><th>Содержание</th><th class = 'BUTTCOLL'>Операции</th></tr><?php PC_Table2($idSuSp); ?></table>
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
			<?php if ($SuSpType==5) : ?>
				<h3 class="panel-title">Знания профессионального модуля <?php getSubject($idSuSp); ?>,<br> специальность <?php getSpecialty($idSpec); ?></h3>
			<?php else : ?>
				<h3 class="panel-title">Знания дисциплины <?php getSubject($idSuSp); ?>,<br> специальность <?php getSpecialty($idSpec); ?></h3>
			<?php endif; ?>
			</div>
			<div class="panel-body">
				<div id = 'KnowForm' class = "rows">
					<div class="col-md-5">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Добавление знаний для дисциплины</h3>
							</div>
							<div class="panel-body">
								<p>Выберите знания:</p>
								<div id = "KnowledgeBlock"></div>
								<br>
								<button id = 'KnowFormButton' onclick = switchData(this.id);>Сохранить</button>
							</div>
						</div>
					</div>
					<div class="col-md-7">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Набор знаний дисциплины</h3>
							</div>
							<div class="panel-body">	
								<table id = "KnowTable" class = 'table table-bordered'><tr><th>Содержание</th><th class = 'BUTTCOLL'>Операции</th></tr><?php Knowledge_Table($idSuSp); ?></table>
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
			<?php if ($SuSpType==5) : ?>
				<h3 class="panel-title">Умения профессионального модуля <?php getSubject($idSuSp); ?>,<br> специальность <?php getSpecialty($idSpec); ?></h3>
			<?php else : ?>
				<h3 class="panel-title">Умения дисциплины <?php getSubject($idSuSp); ?>,<br> специальность <?php getSpecialty($idSpec); ?></h3>
			<?php endif; ?>
			</div>
			<div class="panel-body">
				<div id = 'SkillForm' class = "rows">
					<div class="col-md-5">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Добавление умений для дисциплины</h3>
							</div>
							<div class="panel-body">
								<p>Выберите умения:</p>
								<div id = "SkillBlock"></div>
								<br>
								<button id = 'SkillFormButton' onclick = switchData(this.id);>Сохранить</button>
							</div>
						</div>
					</div>
					<div class="col-md-7">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Набор умений дисциплины</h3>
							</div>
							<div class="panel-body">
								<table id = "SkillTable" class = 'table table-bordered'><tr><th>Содержание</th><th class = 'BUTTCOLL'>Операции</th></tr><?php Skill_Table($idSuSp); ?></table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if ($SuSpType==5) : ?>
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Практический опыт профессионального модуля <?php getSubject($idSuSp); ?>,<br> специальность <?php getSpecialty($idSpec); ?></h3>
			</div>
			<div class="panel-body">
				<div id = 'PractExForm' class = "rows">
					<div class="col-md-5">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Добавление практического опыта для профессионального модуля</h3>
							</div>
							<div class="panel-body">					
								<p>Выберите  практический опыт:</p>
								<div id = "PractExBlock"></div>
								<br>
								<button id = 'PractExFormButton' onclick = switchData(this.id);>Сохранить</button>
							</div>
						</div>
					</div>
					<div class="col-md-7">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Набор практического опыта профессионального модуля</h3>
							</div>
							<div class="panel-body">		
								<table id = "PractExTable" class = 'table table-bordered'><tr><th>Содержание</th><th class = 'BUTTCOLL'>Операции</th></tr><?php PractEx_Table1($idSuSp); ?></table>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
<?php else : header('Location: cabinet.php');?>
<?php endif; ?>
<?php else : header('Location: index.php'); ?>
<?php endif; ?>
</div>	
</body>
</html>

<html>
<title> Создание рабочей программы учебной дисциплины</title>
<head><meta charset=utf8></head>
<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./vendor/bootstrap-3.3.6/css/bootstrap-theme.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link rel="stylesheet" href="./vendor/pure-release-0.6.0/pure-min.css">
<!--<link href="css/grid.css" rel="stylesheet">-->
<style>

	th {
		text-align: center;
	}

	.thTemPlan {
		background-color: white;
	}

	.thEq {
		width: 15%;
	}

	.eq {
		width: 100%;
		height: 100%;
	}

	.eqBut {
		width: 10%;
	}
	
	.headerText {
		text-align: center; 
		font-size: 16px;
	}

	input {
		text-align: center;
	}
	td {
		text-align: center;
	}
/* 	th {
		background-color:#337ab7;
		color: white;
		text-align: center;
	} */
	body {
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
			font-family: Arial;
		}
	
    
	
</style>
<?php

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';
?>
<?php if (Auth\User::isAuthorized()): ?>
<script src="./vendor/jquery-2.0.3.min.js"></script>
<script src="./vendor/jquery.json-1.3.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./js/ajax-form.js"></script>
<script src="./js/js_scripts.js"></script>
<script src="FunctionsForWebforms.js"></script>


<body>
<div class="container">
<h3>Вы авторизованы под учетной записью пользователя <?php echo $_SESSION['username']; ?>.</h3>
<form class="ajax" method="post" action="./ajax.php">
          <input type="hidden" name="act" value="logout">
          <div class="form-actions">
              <button class="btn btn-large btn-primary" type="submit">Выход</button>
          </div><br>
			<ul class="nav nav-pills">
				<li role="nav" class="active"><a href = 'cabinet.php'>Личный кабинет</a></li>
			</ul>
    </form>
<form method = "POST" action = "index1.php">
<h1>Заголовочная таблица</h1>
<hr>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Дата разработки</h3>
            </div>
            <div class="panel-body">
              <input required style='width:100%' id = 'dateCreate' name = 'dateCreate' placeholder = 'дд.мм.гггг'>
            </div>
         </div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-warning">
            <div class="panel-heading">
              <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
				Дата и номер изменения будут указаны в верхнем колонтитуле документа
            </div>
         </div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Изменение №</h3>
            </div>
            <div class="panel-body">
              <input style='width:100%' id = 'numChange' name = 'numChange'>
            </div>
         </div>
	</div>
</div>

<!--<div class = "well">
	<p class = "headerText"> Укажите дату разработки документа и номер изменения, которые будут указаны в заголовочной таблице документа </p>

<table align = center>
<tr>
	<td>Дата разработки: </td> 
	<td><input size = 10 id = 'dateCreate' name = 'dateCreate' placeholder = 'дд.мм.гггг'></td>
</tr>
<tr>	
	<td>Изменение №:</td>
	<td><input size = 10 id = 'numChange' name = 'numChange'></td>
</tr>
</table>
</div>-->

<!--<div class = "well">
	<p class = "headerText"> Выберите специальность </p>
	<select id = 'specialty4' name= "specialty" class = 'specclass' style='width: 100%; align: center'></select>
</div>


<div class = "well">
	<p class = "headerText"> Выберите дисциплину </p>
	<select id = 'SubjSpec' name = "disc" style="width: 100%; align: center" >
		<option id = 0 selected="selected" value = 0>Выберите специальность...</option>
	</select>
</div>-->
<h1>Дисциплина</h1>
<hr>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Специальность</h3>
            </div>
            <div class="panel-body">
              <select id = 'specialty4' name= "specialty" class = 'specclass' style='width: 100%; align: center'></select>
            </div>
         </div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Дисциплина</h3>
            </div>
            <div class="panel-body">
              <select id = 'SubjSpec' name = "disc" style="width: 100%; align: center" >
				<option id = 0 selected="selected" value = 0>Выберите специальность...</option>
			 </select>
            </div>
         </div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Итоговая аттестация в форме</h3>
            </div>
            <div class="panel-body">
				<select id = 'attestation' name = "attestation" style='width: 100%; align: center'>
					<?php
						include './classes/safemysql.class.php';
						$db = new SafeMysql();
						$att = $db->query("select * from Attestation;");
							while ($row = $att->fetch_array()) {
								echo "<option id = ".$row[0]." value = '".$row[1]."'>".$row[1]."</option>";
							}
					?>
					</select>
					<select id = 'attestation2' hidden = hidden name = "attestation2" style='width: 100%; align: center'>
					</select>
            </div>
         </div>
	</div>
</div>

<!--<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Итоговая аттестация в форме</h3>
	</div>
	<div class="panel-body" id = 'crooms'>
	<select id = 'attestation' name = "attestation" style='width: 100%; align: center'>
		<?php
			/* include_once('connect.php');
			global $mysqli;
			$att = $mysqli->query("select * from Attestation;");
				while ($row = $att->fetch_array()) {
					echo "<option id = ".$row[0]." value = '".$row[1]."'>".$row[1]."</option>";
				} */
		?>
		</select>
		<select id = 'attestation2' hidden = hidden name = "attestation2" style='width: 100%; align: center'>
		</select>
	</div>
</div>-->



<!--<div class = "well">
	<p class = "headerText"> Итоговая аттестация в форме </p>
	<select id = 'attestation' name = "attestation" style='width: 100%; align: center'>
	<?php
		/* include_once('connect.php');
		global $mysqli;
		$att = $mysqli->query("select * from Attestation;");
			while ($row = $att->fetch_array()) {
				echo "<option id = ".$row[0]." value = '".$row[1]."'>".$row[1]."</option>";
			} */
	?>
	</select>
	<select id = 'attestation2' hidden = hidden name = "attestation2" style='width: 100%; align: center'>
	</select>
</div>-->
	
	
<div id = 'PCompBlock'> 
</div>

<div id = 'SkillBlock'> 
</div>

<div id = 'KnowledgeBlock'> 
</div>

<div id = 'GCompBlock'> 
</div>


<h1>Помещения</h1>
<hr>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"></h3>
	</div>
	<div class="panel-body" id = 'crooms'>
		Выберите специальность, чтобы увидеть доступные помещения 
	</div>
</div>

<!--<div class = "well">
	<p  class = "headerText"> Помещения </p>
	<div id = 'crooms' class = "CRclass" >
		<p style = "text-align: center"> Выберите специальность, чтобы увидеть доступные помещения </p>
	</div>
</div>-->

<h1> Оборудование </h1>
<hr>
	<div class="col-md-12">
		<div class="panel panel-warning">
            <div class="panel-heading">
              <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
				Оставьте поля в ненужном типе помещения пустыми. Незаполненные поля <strong>не вносятся</strong> в документ
            </div>
         </div>
	</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Учебного кабинета</h3>
            </div>
            <div class="panel-body">
              <table class = 'table table-bordered' id = 'tableEqUm'>			
				<tr>
					<td><input class = 'eq' name = "um0"></td>
					<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableEqUm', 'um')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
				</tr>
			</table>
            </div>
         </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Технических средств обучения</h3>
            </div>
            <div class="panel-body">
				<table class = 'table table-bordered' id = 'tableEqTso'>			
					<tr>
						<td><input class = 'eq' name = "tso0"></td>
						<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableEqTso', 'tso')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
					</tr>
				</table>
            </div>
         </div>
	</div>
</div>


<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Лаборатории и рабочих мест лаборатории</h3>
            </div>
            <div class="panel-body">
              <table class = 'table table-bordered' id = 'tableEqLab'>			
				<tr>
					<td><input class = 'eq' name = "eqLab0"></td>
					<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableEqLab', 'eqLab')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
				</tr>
			</table>
            </div>
         </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Мастерской и рабочих мест мастерской</h3>
            </div>
            <div class="panel-body">
				<table class = 'table table-bordered' id = 'tableEqMas'>			
					<tr>
						<td><input class = 'eq' name = "mas0"></td>
						<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableEqMas', 'mas')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
					</tr>
				</table>
            </div>
         </div>
	</div>
</div>



<!--<div class = "well">
	<p  class = "headerText"> Оборудование </p>
	<div id = 'crooms' class = "CRclass" >
		<table class = 'table table-bordered' id = 'tableEqUm'>			
			<tr>
				<th class = 'thEq'>Учебного кабинета</th>
				<td><input class = 'eq' name = "um0"></td>
				<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableEqUm', 'um')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
			</tr>
		</table>
		
		<table class = 'table table-bordered' id = 'tableEqTso'>			
			<tr>
				<th class = 'thEq'>Технических средств обучения</th>
				<td><input class = 'eq' name = "tso0"></td>
				<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableEqTso', 'tso')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
			</tr>
		</table>
		
		<table class = 'table table-bordered' id = 'tableEqLab'>			
			<tr>
				<th class = 'thEq'>Лаборатории и рабочих мест лаборатории</th>
				<td><input class = 'eq' name = "eqLab0"></td>
				<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableEqLab', 'eqLab')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
			</tr>
		</table>
		
		<table class = 'table table-bordered' id = 'tableEqMas'>			
			<tr>
				<th class = 'thEq'>Мастерской и рабочих мест мастерской</th>
				<td><input class = 'eq' name = "mas0"></td>
				<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableEqMas', 'mas')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
			</tr>
		</table>
	</div>
</div>-->



<h1> Литература</h1>
<hr>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Основные источники</h3>
            </div>
            <div class="panel-body">
             <table class = 'table table-bordered' id = 'tableOLit'>			
				<tr>
					<td><input required class = 'eq' name = "oLit0"></td>
					<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableOLit', 'OLit')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
				</tr>
			</table>
            </div>
         </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Дополнительные источники</h3>
            </div>
            <div class="panel-body">
				<table class = 'table table-bordered' id = 'tableDLit'>			
					<tr>
						<td><input class = 'eq' name = "dLit0"></td>
						<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableDLit', 'dLit')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
					</tr>
				</table>
            </div>
         </div>
	</div>
</div>



<!--<div class = "well">
	<p  class = "headerText"> Перечень рекомендуемых учебных изданий, Интернет-ресурсов, дополнительной литературы </p>
	<div class = "CRclass" >
		<table class = 'table table-bordered' id = 'tableOLit'>			
			<tr>
				<th class = 'thEq'>Основные источники</th>
				<td><input class = 'eq' name = "oLit0"></td>
				<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableOLit', 'OLit')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
			</tr>
		</table>
		
		<table class = 'table table-bordered' id = 'tableDLit'>			
			<tr>
				<th class = 'thEq'>Дополнительные источники</th>
				<td><input class = 'eq' name = "dLit0"></td>
				<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableDLit', 'dLit')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
			</tr>
		</table>
	</div>
</div>-->
<input id = 'countEqLab' hidden = true name = 'countEqLab'>
<input id = 'countEqMas' hidden = true name = 'countEqMas'>
<input id = 'countEqUm' hidden = true name = 'countEqUm'>
<input id = 'countEqTso' hidden = true name = 'countEqTso'>
<input id = 'countDLit' hidden = true name = 'countDLit' value = 0>
<input id = 'countOLit' hidden = true name = 'countOLit' value = 0>
<input id = 'sumAll' hidden = true name = 'sumAll'>
<input id = 'sumPrakt' hidden = true name = 'sumPrakt'>
<input id = 'sumLabor' hidden = true name = 'sumLabor'>
<input id = 'sumSod' hidden = true name = 'sumSod'>
<input id = 'sumSamPrakt' hidden = true name = 'sumSamPrakt'>
<input id = 'sumSamTeor' hidden = true name = 'sumSamTeor'>
<input id = 'maxNumRow' hidden = true name = 'maxNumRow' value = 0>

<h1> Тематический план и содержание учебной дисциплины </h1>
<hr>
<div class="col-md-12">
		<div class="panel panel-warning">
            <div class="panel-heading">
              <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
				После удаления строки, нумерация тем/разделов/работ может сбиться. На нумерацию в документе это <strong>не повлияет</strong>
            </div>
         </div>
	</div>
<table id = 'TemPlan' class = "table table-bordered">
	<tr id='headtab'>
		<th style = "width: 240px" class = 'thTemPlan'>
			<button type = button id = 'newRazd' class = 'btn btn-primary' style = "width:100%" onclick = addRazd()><i class="fa fa-plus" aria-hidden="true"> Раздел</i></button>
			<button type = button id = 'newTem' class = 'btn btn-primary' disabled=true style = "width:100%" onclick = addTem()><i class="fa fa-plus" aria-hidden="true"> Тема</i></button>
			<button type = button id = 'newSod' class = 'btn btn-primary' disabled=true style = "width:100%" onclick = addSod()><i class="fa fa-plus" aria-hidden="true"> Содержание</i></button>
			<button type = button id = 'newPrakt' class = 'btn btn-primary' disabled=true style = "width:100%" onclick = addPrakt()><i class="fa fa-plus" aria-hidden="true"> Практическая работа</i></button>
			<button type = button id = 'newLabor' class = 'btn btn-primary' disabled=true style = "width:100%" onclick = addLabor()><i class="fa fa-plus" aria-hidden="true"> Лабораторная работа</i></button>
			<button type = button id = 'newSamPrakt' class = 'btn btn-primary' disabled=true style = "width:100%" onclick = addSamPrakt()><i class="fa fa-plus" aria-hidden="true"> Сам. работа (практическая)</i></button>
			<button type = button id = 'newSamTeor' class = 'btn btn-primary' disabled=true style = "width:100%" onclick = addSamTeor()><i class="fa fa-plus" aria-hidden="true"> Сам. работа (лекционная)</i></button>
		</th>
		<th style = "width: 240px">Наименование разделов и тем</th>
		<th>Содержание учебного материала, лабораторные  работы и практические занятия, самостоятельная работа обучающихся, курсовая работа (проект)</th>
		<th>Объем часов</th>
		<th style = "width: 40px" >Уровень освоения</th>
		<th></th>
	</tr>
</table>

<br>
<br>
<div id = 'errBlock' ></div>
<input id = 'razdCount' name = 'razdCount' hidden>
<button id = 'checkHours' disabled type = button class = 'btn btn-lg btn-success' onclick = agree()>
	<i class="fa fa-check-square-o" aria-hidden="true"> Проверить объём часов</i>
</button>
<button id = 'submit' disabled type = 'submit' class = 'btn btn-lg btn-success' >
	<i class="fa fa-file-text" aria-hidden="true"> Создать документ</i>
</button>
</form>
</div>

<?php else : header('Location: index.php'); ?>
<?php endif; ?>
</body>
</html>
<?session_start();?>
<html>
<title> Создание программы государственной итоговой аттестации по специальности</title>
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
<form method = "POST" action = "index2.php">
<h1>Заголовочная таблица</h1>
<hr>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Название предприятия</h3>
            </div>
            <div class="panel-body">
              <input required style='width:100%' id = 'company' name = 'company'>
            </div>
         </div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Должность</h3>
            </div>
            <div class="panel-body">
              <input required style='width:100%' id = 'position' name = 'position'>
            </div>
         </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">ФИО</h3>
            </div>
            <div class="panel-body">
              <input required style='width:100%' id = 'fio' name = 'fio'>
            </div>
         </div>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Специальность</h3>
            </div>
            <div class="panel-body">
              <select id = 'specialty4' name= "specialty" class = 'specclass' style='width: 100%; align: center'></select>
            </div>
         </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Тип подготовки</h3>
            </div>
            <div class="panel-body">
                <select id = 'training' name= "training" class = 'training' style='width: 100%; align: center'>
					<option>Базовая подготовка</option>
					<option>Углубленная подготовка</option>
			    </select>
            </div>
         </div>
	</div>
</div>
<h1>Пояснительная записка</h1>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
            <div class="panel-heading">
				<h3 class="panel-title">Фрагмент документа для пояснительной записки. 
					Проверьте, нужно ли его редактировать.</h3>
            </div>
            <div class="panel-body">
				<table class = 'table table-bordered'>
					<tr>
						<td>
							Федеральный государственный образовательный стандарт 
							среднего профессионального образования по специальности 
							<код и наименование специальности>, 
						</td>
					</tr>
					<tr>
						<td>
							<textarea style='width:100%' id = 'explanatoryNote1' name = 'explanatoryNote1'
							>утвержденный приказом Министерства образования и науки Российской Федерации</textarea>
						</td>
					</tr>
					<tr>
						<td>
							от
							<select required id = 'explanatoryNoteYear1' name = 'explanatoryNoteYear1'>
								<?php
									$year = date(Y);
									while( $year >= 1901 ){
										echo "<option>".$year."</option>";
										$year--;
									}
								?>
							</select>
							 года № 
							 <input required id = 'explanatoryNoteNumber1' name = 'explanatoryNoteNumber1'>
							 (зарегистрированный в Министерстве юстиции от
							 <select required id = 'explanatoryNoteYear2' name = 'explanatoryNoteYear2'>
								<?php
									$year = date(Y);
									while( $year >= 1901 ){
										echo "<option>".$year."</option>";
										$year--;
									}
								?>
							</select> 
							 года  №
							<input required id = 'explanatoryNoteNumber2' name = 'explanatoryNoteNumber2'>
						</td>
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
              <h3 class="panel-title">подготовка ВКР - 4 недели</h3>
            </div>
            <div class="panel-body">
				<table class = 'table table-bordered'>
				<tr>
					<td>
						с
						<input required id = "trainingVKR-S" name= "trainingVKR-S">
						по
						<input required id = "trainingVKR-PO" name= "trainingVKR-PO">
					</td>	
				</tr>
				</table>
            </div>
         </div>
	</div>
		<div class="col-md-6">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">защита ВКР - 2 недели</h3>
            </div>
            <div class="panel-body">
				<table class = 'table table-bordered'>
				<tr>
					<td>
						с
						<input required id = "protectionVKR-S" name= "protectionVKR-S">
						по
						<input required id = "protectionVKR-PO" name= "protectionVKR-PO">
					</td>	
				</tr>
				</table>
            </div>
         </div>
	</div>
</div>
<h1>СОДЕРЖАНИЕ И СТРУКТУРА ГОСУДАРСТВЕННОЙ ИТОГОВОЙ АТТЕСТАЦИИ</h1>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Дата утверждения ОПОП</h3>
            </div>
            <div class="panel-body">
              <input required style='width:100%' id = 'date' name = 'date' placeholder = 'дд.мм.гггг'>
            </div>
         </div>
	</div>
</div>
<br>
<br>
<br>
<br>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
            <div class="panel-heading">
				<h3 class="panel-title">Программа ГИА предусматривает проверку освоения следующих видов профессиональной деятельности (ВПД):</h3>
            </div>
            <div class="panel-body">
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Вид деятельности 1</h3>
							</div>
							<div class="panel-body">
								<input required style='width:100%' id = 'activityOne' name = 'activityOne'>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Вид деятельости 2</h3>
							</div>
							<div class="panel-body">
								<input required style='width:100%' id = 'activityTwo' name = 'activityTwo'>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Выполнение работ по профессии</h3>
							</div>
							<div class="panel-body">
								<input required style='width:100%' id = 'profession' name = 'profession'>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">(Список работ по профессии)</h3>
							</div>
							<div class="panel-body">
								<table class = 'table table-bordered' id = 'tableEqTso'>			
									<tr>
										<td><input required class = 'eq' name = "tso0"></td>
										<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableEqTso', 'tso')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">(4 пункт списка)</h3>
							</div>
							<div class="panel-body">
								<input required style='width:100%' id = 'fourPoint' name = 'fourPoint'>
							</div>
						</div>
					</div>
				</div>
			</div>
         </div>
	</div>
</div>
<br>
<br>
<br>
<br>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Введите список компетенций, необходимых для выполнения работ по профессии (обратите внимание на правильную нумерацию компетенций).</h3>
			</div>
			<div class="panel-body">
				<table class = 'table table-bordered' id = 'tableEqLab'>			
					<tr>
						<td><input required class = 'eq' name = "eqLab0" placeholder = 'ПК 3.1.1 Профессиональная компетенция'></td>
						<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableEqLab', 'eqLab')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Введите список компетенций для пункта 4.</h3>
			</div>
			<div class="panel-body">
				<table class = 'table table-bordered' id = 'tableDLit'>			
					<tr>
						<td><input required class = 'eq' name = "dLit0" placeholder = 'ПК 4.1 Профессиональная компетенция'></td>
						<td class = 'eqBut'><button type = button class = 'btn btn-primary' style = "width:100%" onclick = "addEqRow('tableDLit', 'dLit')"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<br>
<br>
<br>
<br>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Наименование ПЦК</h3>
            </div>
            <div class="panel-body">
              <input required style='width:100%' id = 'Name_PCK' name = 'Name_PCK'>
            </div>
         </div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Наименование квалификации</h3>
            </div>
            <div class="panel-body">
              <input required style='width:100%' id = 'Name_Qualification' name = 'Name_Qualification'>
            </div>
         </div>
	</div>
</div>
<h1>ОЦЕНКА РЕЗУЛЬТАТОВ ГОСУДАРСТВЕННОЙ ИТОГОВОЙ АТТЕСТАЦИИ</h1>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Название проекта, разрабатываемого студентом</h3>
            </div>
            <div class="panel-body">
              <input required style='width:100%' id = 'Name_Project' name = 'Name_Project'>
            </div>
         </div>
	</div>
</div>



<div id = 'PCompBlock'> 
</div>

<div id = 'SkillBlock'> 
</div>

<div id = 'KnowledgeBlock'> 
</div>

<div id = 'GCompBlock'> 
</div>
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

<div id = 'errBlock' ></div>

<button id = 'submit'  class = 'btn btn-lg btn-success' >
	<i class="fa fa-file-text" aria-hidden="true"> Создать документ</i>
</button>
</form>
</div>

<?php else : header('Location: index.php'); ?>
<?php endif; ?>
</body>
</html>
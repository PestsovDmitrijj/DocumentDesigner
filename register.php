<?php
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';
include_once './getData.php';
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Регистрация пользователей</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
	<?php if (Auth\User::isAuthorized()): ?>
	<?php if ($_SESSION['idRole']==1) : ?>
    <div class="container">
	<h3>Вы авторизованы под учетной записью пользователя <?php echo $_SESSION['username']; ?>.</h3>
      <form class="ajax" method="post" action="./ajax.php">
          <input type="hidden" name="act" value="logout">
          <div class="form-actions">
              <button class="btn btn-large btn-primary" type="submit">Выход</button>
          </div><br>
		  <ul class="nav nav-pills">
			  <li role="nav" class="active"><a href = 'cabinet.php'>Личный кабинет</a></li>
			  <li role="nav"><a href = 'datauser.php'>Управление пользователями</a></li>
		</ul>
      </form>
		<form class="form-signin ajax" method="post" action="./ajax.php">
        <div class="main-error alert alert-error hide"></div>
        <h2 class="form-signin-heading">Регистрация новых пользователей</h2>
        <input name="username" type="text" class="input-block-level" placeholder="Логин" autofocus>
        <input name="password1" type="password" class="input-block-level" placeholder="Пароль">
        <input name="password2" type="password" class="input-block-level" placeholder="Подтвердите пароль">
		<select name="idRole">
			<option value = '0'>--Выбрать роль--</option>
			<?php echo Role_Select(); ?>
		</select>
        <input type="hidden" name="act" value="register">
        <button class="btn btn-large btn-primary" type="submit">Регистрация</button>
      </form>
    </div> <!-- /container -->
	<?php else : header('Location: cabinet.php');?>
<?php endif; ?>
<?php else : header('Location: index.php'); ?>
<?php endif; ?>
    <script src="./vendor/jquery-2.0.3.min.js"></script>
    <script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="./js/ajax-form.js"></script>
  </body>
</html>

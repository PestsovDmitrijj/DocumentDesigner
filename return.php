<?php
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once './classes/Auth.class.php';
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Смена пароля</title>
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <link rel="stylesheet" href="./vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <div class="container">
<?php if(Auth\User::isAuthorized()): ?>
<h3>Вы авторизованы под учетной записью пользователя <?php echo $_SESSION['username']; ?>.</h3>
      <form class="ajax" method="post" action="./ajax.php">
          <input type="hidden" name="act" value="logout">
          <div class="form-actions">
              <button class="btn btn-large btn-primary" type="submit">Выход</button>
          </div>
			<ul class="nav nav-pills">
				<li role="nav" class="active"><a href = 'cabinet.php'>Личный кабинет</a></li>
			</ul>
      </form>
      <form class="form-signin ajax" method="post" action="./ajax.php">
        <div class="main-error alert alert-error hide"></div>
       <h2 class="form-signin-heading">Смена пароля</h2>
        <input name="old_password" type="password" class="input-block-level" placeholder="Старый пароль">
              <input name="new_password" type="password" class="input-block-level" placeholder="Новый пароль">
        <input name="new_password2" type="password" class="input-block-level" placeholder="Подтвердите новый пароль">
        <input type="hidden" name="act" value="change_password">
		 <input type="hidden" name="username" value="<?php echo  $_SESSION['username'];?>">
        <button class="btn btn-large btn-primary" type="submit">Сменить пароль</button>
      </form>
<?php else : header('Location: index.php'); ?>
<?php endif; ?>
    </div> <!-- /container -->
    <script src="./vendor/jquery-2.0.3.min.js"></script>
    <script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="./js/ajax-form.js"></script>
  </body>
</html>
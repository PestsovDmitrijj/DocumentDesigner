<?php
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once 'classes/Auth.class.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Авторизация</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <div class="container">
      <?php if (Auth\User::isAuthorized()): ?>
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
      <?php else: ?>
      <form class="form-signin ajax" method="post" action="./ajax.php">
        <div class="main-error alert alert-error hide"></div>
        <h2 class="form-signin-heading">Пожалуйста, авторизуйтесь</h2>
        <input name="username" type="text" class="input-block-level" placeholder="Логин" autofocus>
        <input name="password" type="password" class="input-block-level" placeholder="Пароль">
        <label class="checkbox">
          <input name="remember-me" type="checkbox" value="remember-me" checked = 'false'> Запомнить меня
        </label>
        <input type="hidden" name="act" value="login">
        <button class="btn btn-large btn-primary" type="submit">Вход</button>
      </form>
      <?php endif; ?>
    </div> <!-- /container -->
    <script src="./vendor/jquery-2.0.3.min.js"></script>
    <script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="./js/ajax-form.js"></script>
  </body>
</html>

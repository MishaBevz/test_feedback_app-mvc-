<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 19.11.2016
 * Time: 16:20
 */
define('ROOT', dirname(__FILE__));
require_once (ROOT.'/controllers/UsersController.php');
session_start();
$auth = UsersController::userLogin();

?>

</<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php require_once (ROOT.'/title.php') ?>
<div class="container">
<form method="post" class="form-signin" role="form">
    <h2 class="form-signin-heading">Вход в систему</h2>
    <input type="text" name="login" class="form-control" id="inputLogin" placeholder="Логин" required>
    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Пароль" required>
    <button type="submit" name="send"  class="btn btn-default">Войти</button>

</form>
    <h3 align="center">Не зарегистрированы?</h3>
    <h3 align="center"><a href="register_form.php">Регистрация</a></h3>

</div>

</body>
</html>

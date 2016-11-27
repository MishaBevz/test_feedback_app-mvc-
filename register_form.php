<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 19.11.2016
 * Time: 16:36
 */
define('ROOT', dirname(__FILE__));
require_once (ROOT.'/controllers/UsersController.php');
session_start();
$register = UsersController::userRegister();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php require_once (ROOT.'/title.php') ?>
<h1 align="center">Регистрация:</h1>
<form method="post" class="form-signin">
    <input type="text" name="register_name" class="form-control" placeholder="Логин" required>
    <input type="password" name="register_password" class="form-control" placeholder="Пароль" required>
    <button type="submit" name="send" class="btn btn-default">Зарегистрироваться</button>
</form>

</body>
</html>

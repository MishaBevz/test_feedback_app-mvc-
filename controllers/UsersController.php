<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 27.11.2016
 * Time: 11:25
 */
require_once (ROOT.'/models/Users.php');

class UsersController{

    public static function userRegister(){
        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
        or die ("Ошибка" . mysqli_error($link));

        if(isset($_POST['register_name']) && isset($_POST['register_password'])){
            $register_name = clean($_POST['register_name']);
            $register_password = clean($_POST['register_password']);

            $check_register = Users::checkRegister($register_name);
            if(mysqli_num_rows($check_register) > 0 ){

                echo "<br><br>" . "Пользователь" . " " . $register_name . " " .  "уже существует";

            }

            else{
                if($register_name=="admin" && $register_password=="123"){
                    Users::userRegister($register_name,$register_password);
                    echo "<br><br>" . "Регистрация прошла успешно!" . " " . "<a href='login_form.php'>Войти</a>";
                }

                else {
                    echo "<br><br>" . "Данные введены неккоректно.Попробуйте снова";
                }
            }
        }

        return true;

    }


    public static function userLogin(){
        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
        or die ("Ошибка" . mysqli_error($link));



        if(isset($_POST['login']) && isset($_POST['password'])){

            $login = $_POST['login'];
            $password = $_POST['password'];
            $data = Users::userLogin($login);
            if($data['login'] == $login && $data['password']==$password){
                $_SESSION['login'] = $login;
                header('Location: /') ;

            }
            else{
                echo "<br><br>" . "Неверные данные";
                $_SESSION["is_auth"] = false;
            }
        }

    }


}
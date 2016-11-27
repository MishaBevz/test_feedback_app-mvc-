<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 27.11.2016
 * Time: 11:25
 */
require_once (ROOT.'/settings/components.php');

class Users{

    public static function userRegister($register_name,$register_password){

        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
        or die ("Ошибка" . mysqli_error($link));


        $query="INSERT INTO users VALUES ('','$register_name','$register_password')";
        $registerUser=mysqli_query($link,$query);

        return $registerUser;

    }


    public static function checkRegister($register_name){
        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
        or die ("Ошибка" . mysqli_error($link));

        $query = "SELECT * FROM users WHERE login='$register_name'";
        $check_register = mysqli_query($link,$query);

        return $check_register;
    }


    public static function userLogin($login){

        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
        or die ("Ошибка" . mysqli_error($link));

        $query = "SELECT * FROM users WHERE login = '$login'";
        $result = mysqli_query($link,$query);
        $data = mysqli_fetch_assoc($result);

        return $data;

    }

}
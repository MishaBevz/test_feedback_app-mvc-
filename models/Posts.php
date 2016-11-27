<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 26.11.2016
 * Time: 18:11
 */
require_once (ROOT.'/settings/components.php');

class Posts{
    public static function all(){
        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
                or die ("Ошибка" . mysqli_error($link));

        $query = "SELECT * FROM feedback"; // Выбираем нужные нам данные.Переменная $key отвечает за выбор поля таблицы,а переменная $key2 - в каком направлении данные будут сортироваться.
        $posts = mysqli_query($link,$query)
                    or die ("Ошибка" . mysqli_error($link));

        return $posts;

    }


    public static function allAdmin($key,$key2){

        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
                or die ("Ошибка" . mysqli_error($link));

        $query = "SELECT * FROM feedback ORDER BY $key $key2 "; // Выбираем нужные нам данные.Переменная $key отвечает за выбор поля таблицы,а переменная $key2 - в каком направлении данные будут сортироваться.
        $posts = mysqli_query($link,$query)
                or die ("Ошибка" . mysqli_error($link));
        return $posts;
    }

    public static function allPublish($key,$key2){

        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
                or die ("Ошибка" . mysqli_error($link));

        $query = "SELECT * FROM feedback WHERE publish = 1 ORDER BY $key $key2 "; // Выбираем нужные нам данные.Переменная $key отвечает за выбор поля таблицы,а переменная $key2 - в каком направлении данные будут сортироваться.
        $posts = mysqli_query($link,$query)
                or die ("Ошибка" . mysqli_error($link));
        return $posts;
    }

    public static function postId($id){
        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
        or die ("Ошибка" . mysqli_error($link));


        $query = "SELECT * FROM feedback WHERE id = '$id'";
        $result = mysqli_query($link,$query);
        $post = mysqli_fetch_array($result);
        return $post;

    }



    public static function postEdit($name,$email_validate,$message,$publish,$id){

        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
                or die ("Ошибка" . mysqli_error($link));

        $query ="UPDATE feedback SET name='$name', email='$email_validate', message='$message', publish = '$publish' WHERE id='$id'";
        $postEdit=mysqli_query($link,$query) or die ("Ошибка" . mysqli_error($link));

        return $postEdit;
    }

    public static function imageEdit($image,$id){
        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
        or die ("Ошибка" . mysqli_error($link));

        $query ="UPDATE feedback SET image='$image' WHERE id='$id'";
        $imageEdit =mysqli_query($link,$query);

        return $imageEdit;
    }

    public static function AddPostAndImage($name,$email_validate,$image,$message,$date){
        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
                or die ("Ошибка" . mysqli_error($link));

        $query_feedbackForm = "INSERT INTO feedback VALUES ('','$name','$email_validate','$image','$message','$date','')";
        $postAdd = mysqli_query($link,$query_feedbackForm) or die ("Ошибка" . mysqli_error($link));

        return $postAdd;

    }

    public static function AddPostWithoutImage($name,$email_validate,$message,$date){
        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
        or die ("Ошибка" . mysqli_error($link));

        $query_feedbackForm = "INSERT INTO feedback VALUES ('','$name','$email_validate','','$message','$date','')";
        $postAdd = mysqli_query($link,$query_feedbackForm) or die ("Ошибка" . mysqli_error($link));

        return $postAdd;

    }
}
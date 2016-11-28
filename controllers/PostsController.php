<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 26.11.2016
 * Time: 18:33
 */
require_once (ROOT.'/models/Posts.php');

class PostsController{

    public static function showPosts(){
        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
                or die ("Ошибка" . mysqli_error($link));

        // если значения переменных $key и $key2 не определены - присваиваем им значения по умолчанию.
        if(!isset($key)){
            $key = "date";
        }
        if(!isset($key2)){
            $key2 = "DESC";
        }

        // Если GET запрос передает определенное значение - присваиваем переменным $key и $key2 нужные нам значения.
        if(isset($_GET['date'])){
            $key = "date";
            $key2 = "ASC";
            

        }

        if (isset($_GET['name'])){
            $key = "name";
            $key2 = "ASC";

        }

        if (isset( $_GET['email'])){
            $key = "email";
            $key2 = "ASC";
        }

        if (isset($_SESSION['login'])){
            $posts = Posts::allAdmin($key,$key2);
        }else{
            $posts = Posts::allPublish($key,$key2); // Выбираем нужные нам данные.Переменная $key отвечает за выбор поля таблицы,а переменная $key2 - в каком направлении данные будут сортироваться.

        }
        return $posts;

    }

    public static function postId(){
        if(isset($_SESSION['login'])){
            if(isset($_GET['id'])){
                $id = intval($_GET['id']);
                $postId = Posts::postId($id);

            }
        }
        return $postId;
    }


    public static function postEdit(){
        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
                or die ("Ошибка" . mysqli_error($link));
        // Проверяем на сессию:
        if(isset($_SESSION['login'])){
            if(isset($_GET['id'])){
                $id = intval($_GET['id']);
                if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message']) && isset($_POST['publish'])){ //Проверяем,отличные ли от Null пришли данные.
                    // Фильтруем данные (о функции 'clean' подробности в файле settings.php)
                    $name = clean($_POST['name']);
                    $email = clean($_POST['email']);
                    $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL);
                    $message = clean($_POST['message']);
                    $publish = $_POST['publish'];
                    if(check_length($name, 2, 25) && check_length($message, 10, 1000) && $email_validate) {
                        // Обновляем базу данных, если все хорошо.
                        Posts::postEdit($name,$email_validate,$message,$publish,$id);
                        header("Location: /edit.php?id=$id");

                    if($_FILES['picture']['type'] == "image/gif" || $_FILES['picture']['type'] == "image/jpeg" || $_FILES['picture']['type'] == "image/png"){
                        // Путь загрузки файлов:
                        $uploaddir = 'templates/img/';
                        // Имя файла:
                        $uploadfile = $uploaddir . time();
                        // Шифруем имя файла, дабы избежать одинаковых имен файлов в будущем:
                        $uploadfile = $uploaddir . md5($uploadfile) . rand(999,100000) . "." . basename($_FILES['picture']['type']);
                        move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile);
                        $image = $uploadfile ;
                        Posts::imageEdit($image,$id);
                        header("Location: /edit.php?id=$id");
                        return true;
                    }

                    }
                }
            }
        }


    }



    public static function postAdd(){
        $host = 'test';
        $database = 'test';
        $user = 'root';
        $password = '' ;
        $link=mysqli_connect($host, $user, $password,$database)
        or die ("Ошибка" . mysqli_error($link));

        if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])){ //Проверяем,отличные ли от Null пришли данные.
            // Фильтруем данные (о функции 'clean' подробности в файле settings.php)
            $name = clean($_POST['name']);
            $email = clean($_POST['email']);
            $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL);
            $message = clean($_POST['message']);
            $date = date("Y-m-d H:i:s");


            // Далее делаем проверку на наличие загруженных файлов.
            // Проверяем тип файлов.
            if($_FILES['picture']['type'] == "image/gif" || $_FILES['picture']['type'] == "image/jpeg" || $_FILES['picture']['type'] == "image/png"){

                // Путь загрузки файлов:
                $uploaddir = 'templates/img/';

                // Имя файла:
                $uploadfile = $uploaddir . time();

                // Шифруем имя файла, дабы избежать одинаковых имен файлов в будущем:
                $uploadfile = $uploaddir . md5($uploadfile) . rand(999,100000) . "." . basename($_FILES['picture']['type']);
                $image = $uploadfile;
                move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile);
                // Проверка данных на валидность(о функции 'check_length' подробности в файле settings.php) :
                if(check_length($name, 2, 25) && check_length($message, 10, 1000) && $email_validate) {
                    // Если все хорошо, отправляем сообщение на электронную почту:
                    $to = "";
                    $subject = "Отзыв от:" . " " . $name . " " . "<$email_validate>";
                    $mail_message = $message;
                    mail($to, $subject, $mail_message);
                    // И добавляем данные в таблицу:
                    $postAdd = Posts::AddPostAndImage($name,$email_validate,$image,$message,$date);
                    echo "<br><br>" . "Отзыв успешно отправлен.После проверки ваш отзыв появится на странице.";
                    header('Location: /');
                    return $postAdd;
                    
                }else {
                    echo "<br><br>" . "Введенные данные некорректные" ;
                }
            }
            else {
                // Проверка данных на валидность(о функции 'check_length' подробности в файле settings.php) :
                if(check_length($name, 2, 25) && check_length($message, 10, 1000) && $email_validate) {
                    // Если все хорошо, отправляем сообщение на электронную почту:
                    $to = "";
                    $subject = "Отзыв от:" . " " . $name . " " . "<$email_validate>";
                    $mail_message = $message;
                    mail($to, $subject, $mail_message);
                    // И добавляем данные в таблицу:

                    $postAdd = Posts::AddPostWithoutImage($name,$email_validate,$message,$date);
                    echo "<br><br>" . "Некорректный формат файла.Доступные форматы:PNG,JPEG,GIF.";
                    echo "<br><br>" . "Отзыв отправлен,но без загруженного файла.После проверки ваш отзыв появится на странице.";
                    header('Location: /');
                    return $postAdd;
                    
                } else {
                    echo "<br><br>" . "Введенные данные некорректные" ;
                }
            }
        }
    }




}

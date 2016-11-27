<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 21.11.2016
 * Time: 20:21
 */
define('ROOT', dirname(__FILE__));

require_once (ROOT.'/controllers/PostsController.php');
session_start();
$postId = PostsController::postId();
$postEdit = PostsController::postEdit();


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
<?php if(isset($_SESSION['login'])):// Если администратор авторизован, пускаем его к редактору ?>
<?php require_once (ROOT.'/title.php') ?>
<h1 align="center">Редактор отзыва</h1>
<div class="center">
<blockquote>

<h3><?php echo $postId['name']?></h3>
<h4><?php echo $postId['email']?></h4>
<p><img src="<?php echo $postId['image']?>" width="320" height="240" ></p>
<p><?php echo $postId['message']?></p>
<small><?php echo $postId['date']?></small>
<?php if($postId['publish']==1):?>
    <p>Опубликовано <span class="glyphicon glyphicon-ok"></span></p>
<?php else:?>
    <p>Не опубликовано <span class="glyphicon glyphicon-remove"></span></p>
<?php endif; ?>

</blockquote>
</div>
<hr>
<br>


<form method="post" enctype="multipart/form-data" class="form-horizontal" role="form">

    <div class="form-group">
        <label class="col-sm-4 control-label">Имя</label>
        <div class="col-sm-4">
    <input type="text" name="name" class="form-control" value="<?php echo $postId['name']?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Email</label>
        <div class="col-sm-4">
    <input type="text" name="email" class="form-control" value="<?php echo $postId['email']?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Фото</label>
        <div class="col-sm-4">
    <input type="file" name="picture" placeholder="Новая картинка">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Сообщение</label>
        <div class="col-sm-4">
    <textarea name="message" class="form-control" placeholder="Новое сообщение"><?php echo $postId['message']?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Публикация</label>
        <div class="col-sm-4">
    <select name="publish" class="form-control" >
        <?php if($postId['publish']==1):?>
        <option value="1">Опубликовать отзыв</option>
        <option value="0">Скрыть отзыв</option>
        <?php else:?>
        <option value="0">Скрыть отзыв</option>
        <option value="1">Опубликовать отзыв</option>
        <?php endif;?>

    </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-5 col-sm-10">
    <input type="submit" name="send" class="btn btn-default" value="Сохранить">
        </div>
    </div>
</form>

<?php endif;?>

    </div>
</div>
</body>
</html>

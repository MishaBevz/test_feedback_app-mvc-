<?php
/**
 * Created by PhpStorm.
 * User: Михаил
 * Date: 18.11.2016
 * Time: 12:50
 */
define('ROOT', dirname(__FILE__));
require_once (ROOT.'/controllers/PostsController.php');
session_start();
$postsList = PostsController::showPosts();
PostsController::postAdd();


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Отзывы</title>
    <style>
        .center {
            text-align: center;
        }
    </style>
    <script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" ></script>
    <script>
        $(document).ready(function () {
            $("#imagePreview").hide();
            $("#previewbutton").click(function () {
                $("#preview").text("Предварительный просмотр:");
                $("#imagePreview").show();
            });
            $("#name").keyup(function () {
                var value = $(this).val();
                $("#previewbutton").click(function () {
                    $("#namePreview").text(value);
                });
            });
            $("#email").keyup(function () {
                var value = $(this).val();
                $("#previewbutton").click(function () {
                    $("#emailPreview").text(value);
                }).keyup();
            });


                function handleFileSelect(evt) {
                    var files = evt.target.files; // FileList object
                    var output = [];
                    // Loop through the FileList and render image files as thumbnails.
                    for (var i = 0, f; f = files[i]; i++) {

                        output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
                            f.size, ' bytes, last modified: ',
                            f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
                            '</li>');

                        document.getElementById('hm').innerHTML = '<ul>' + output.join('') + '</ul>';



                        // Only process image files.
                        if (!f.type.match('image.*')) {
                            continue;
                        }

                        var reader = new FileReader();

                        // Closure to capture the file information.
                        reader.onload = (function(theFile) {
                            return function(e) {
                                // Render thumbnail.
                                var span = document.createElement('span');
                                span.innerHTML = ['<img class="thumb" width="320px" height="240px" src="', e.target.result,
                                    '" title="', theFile.name, '"/>'].join('');
                                document.getElementById('list').insertBefore(span, null);
                            };
                        })(f);

                        // Read in the image file as a data URL.
                        reader.readAsDataURL(f);
                    }
                }

                document.getElementById('image').addEventListener('change', handleFileSelect, false);


            $("#message").keyup(function () {
                var value = $(this).val();
                $("#previewbutton").click(function () {
                    $("#messagePreview").text(value);
                }).keyup();
            });
        });
    </script>


</head>
<body>
<?php require_once (ROOT.'/title.php') ?>

<div class="container">
    <div class="row">
<ul>
    <h1>Отзывы:<br></h1>
    <li><a href="/">Сортировать по дате(сначала новые,стоит по умолчанию)</a></li>
    <li><a href="index.php?date=sort">Сортировать по дате(сначала старые)</a></li>
    <li><a href="index.php?name=sort">Сортировать по имени (в алфавитном порядке)</a></li>
    <li><a href="index.php?email=sort">Сортировать по email (в алфавитном порядке)</a></li>
</ul>

<br>

<hr>


<?php foreach($postsList as $post): //Вывод отзывов на страничку ?>

<div class="center">

<blockquote>
<h3><?php echo $post['name']?>
<small><?php echo $post['email']?></small></h3>

<?php if($post['image']):?>
<p><img src="<?php echo $post['image']?>" width="320px" height="240px"></p>
<?php else:?>
<br>
<?php endif;?>

<p><?php echo $post['message']?></p>
<small><?php echo $post['date']?></small>
</blockquote>


<?php if(isset($_SESSION['login'])):?>
    <?php if($post['publish']==1):?>
        <p>Опубликовано <span class="glyphicon glyphicon-ok"></span></p>
    <?php else:?>
        <p>Не опубликовано <span class="glyphicon glyphicon-remove"></span></p>
    <?php endif; ?>
    <p><a href="edit.php?id=<?php echo $post['id']?>">Редактировать отзыв  <span class="glyphicon glyphicon-pencil"></span></a>  </p>
<?php endif;?>
    <hr>
<?php endforeach; ?>
</div>

<br>
<div class="center">
    <h3>Форма обратной связи:</h3<br>
</div>
<div class="col-md-12 col-md-offset-4">
<form method="post" enctype="multipart/form-data" class="form-horizontal" role="form" >
    <div class="form-group">
        <label class="col-sm-1 control-label">Имя</label>
        <div class="col-sm-3">
    <input type="text" name="name" class="form-control" id="name" placeholder="Имя" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label">Email</label>
        <div class="col-sm-3">
    <input type="email" name="email" class="form-control" id="email" placeholder="Ваш email" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label">Фото</label>
        <div class="col-sm-3">
    <input type="file" name="picture" id="image"><output id="hm"></output>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label">Сообщение</label>
        <div class="col-sm-3">
    <textarea name="message" class="form-control" id="message" placeholder="Введите сообщение"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-5">
    <input type="submit" name="send" class="btn btn-default"> <input type="button" name="button" class="btn btn-default" id="previewbutton" value="Предварительный просмотр">
            </div>
        </div>
</form>
    </div>
</div>

<br>
<div class="center">
<h2 id="preview"></h2>
<h3 id="namePreview"></h3>
<h4 id="emailPreview"></h4>
<p id="imagePreview"><output id="list"></output></p>
<p id="messagePreview"></p>
</div>
    </div>
</div>
</body>
</html>

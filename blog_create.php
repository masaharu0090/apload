<?php 
require_once('blog.php');

$blogs = $_POST;
//var_dump($blogs);



$blog  = new Blog();
$blog->blogValidate($blogs);
$blog->blogCreate($blogs);

?>
<p><a href="/PHPでWEB日記を作成/index2">戻る</a></p>


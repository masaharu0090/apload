<?php 


require_once('blog.php');


$blog  = new Blog();
$result = $blog->delete($_GET['id']);

?>
<p><a href="/PHPでWEB日記を作成/index2">戻る</a></p>
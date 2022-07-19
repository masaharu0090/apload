<?php 
ini_set('display_errors', "On");
// 1 require_onceを使ってみよう!
require_once('blog.php');
// 2 namaespaceを設定しよう！
// 3 useを使おう！


$blog  = new Blog();
$result = $blog->getById($_GET['id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ詳細</title>
</head>
<body>
    <h2>ブログ詳細</h2>
    <h3>タイトル：<?php echo htmlspecialchars($result['title'])?></h3>
    <p>投稿日時：<?php echo htmlspecialchars($result['post_at'], ENT_QUOTES, "UTF-8")?></p>
    <p>カテゴリ：<?php echo htmlspecialchars($blog->setCategoryName($result['category'], ENT_QUOTES, "UTF-8"))?></p>
    <hr>
    <p>本文：<?php echo htmlspecialchars($result['content'], ENT_QUOTES, "UTF-8")?></p>
    <p><a href="/PHPでWEB日記を作成/index2">戻る</a></p>
</body>
</html>
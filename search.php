<?php

require_once('blog.php');
$blog  = new Blog();
$result = $blog->getByTitle($_POST['title']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
</head>

<body>
    <h2>検索結果</h2>
    <table>
        <tr>
            <th>タイトル</th>
            <th>カテゴリー</th>
            <th>投稿日時</th>
            <th>Detail</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        <tr>
            <td><?php echo $result['title']?></td>
            <td><?php echo  $result['category'] ?></td>
            <td><?php echo $result['post_at'] ?></td>
            <td><a href="/detail.php?id=<?php echo $result['id'] ?>">詳細</a></td>
            <td><a href="/update_form.php?id=<?php echo $result['id'] ?>">編集</a></td>
            <td><a href="/blog_delete.php?id=<?php echo $result['id'] ?>">削除</a></td>
        </tr>

    </table>
    <p><a href="/PHPでWEB日記を作成/index2.php">戻る</a></p>
</body>

</html>
<?php

use function Blog\Dbc\getAllBlog;
use function Blog\Dbc\setCategoryName;

require_once('blog.php');
$blog = new Blog();
// 取得したデーターを表示
$blogData = $blog->getAll();

function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ一覧</title>
</head>

<body>
    <h2>ブログ一覧</h2>
    <p><a href="/PHPでWEB日記を作成/form.html">新規作成</a></p>
    <br>
    <!-- 検索 -->
    <form action="/PHPでWEB日記を作成/search.php" method="POST">
        <p>
            ブログタイトル検索：
            <input type="text" name="title" >
            <input type="submit" name="submit" value="検索">
        </P>
    </form>
        <table>
            <tr>
                <th>タイトル</th>
                <th>カテゴリー</th>
                <th>投稿日時</th>
                <th>Detail</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            <?php foreach ($blogData as $column) : ?>
                <tr>
                    <td><?php echo h($column['title']) ?></td>
                    <td><?php echo h($blog->setCategoryName($column['category'])) ?></td>
                    <td><?php echo h($column['post_at']) ?></td>
                    <td><a href="/PHPでWEB日記を作成/detail.?id=<?php echo $column['id'] ?>">詳細</a></td>
                    <td><a href="/PHPでWEB日記を作成/update_form.?id=<?php echo $column['id'] ?>">編集</a></td>
                    <td><a href="/PHPでWEB日記を作成/blog_delete.?id=<?php echo $column['id'] ?>">削除</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
</body>

</html>
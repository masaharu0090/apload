<?php 

require_once "./dbc.php";
// ファイル関連の取得
$file = $_FILES['img'];
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
$upload_dir = 'images/';
$save_filename = date('YmdHis') . $filename;
$err_msgs = array();
$save_path = $upload_dir. $save_filename;



// 拡張は画像形式か
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);

if(!in_array(strtolower($file_ext), $allow_ext)) {
    array_push($err_msgs, '画像ファイルを添付してください。');
}

if (count($err_msgs) === 0 ) {
    // ファイルはあるかどうか?
    if (is_uploaded_file($tmp_path)) {
        if (move_uploaded_file($tmp_path, $save_path)) {
            echo $filename . 'を'. $upload_dir . 'にアップしました。 ';
            // DBに保存（ファイル名、ファイルパス、キャプション）
            $result = fileSave($filename, $save_path, $caption);

            if ($result) {
                echo 'データベースに保存しました！';
          
            }
        } else {
            echo 'ファイルが保存できませんでした。';
        }
    } else {
        echo 'ファイルが選択されません。';
        echo '<br>';
    }
} else {
    foreach($err_msgs as $msg) {
        echo $msg;
        echo '<br>';
    }
}
    ?>
    <a href="./upload_form.php">戻る</a>

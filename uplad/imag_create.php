
<?php
 
 /* 設定 */
 $range = range(0, 2); // upfileの使用するキーの範囲
 $dir = './images'; // 保存に使用するディレクトリ
  
 if (isset($_POST['uploadfile'], $_FILES['upfile']['error']) && is_array($_FILES['upfile']['error'])) {
     
     // 各ファイルをチェック
     foreach ($_FILES['upfile']['error'] as $k => $error) {
  
         try {
  
             // 更に配列がネストしている、または想定外のキーであれば不正とする
             $k = (int)$k;
             if (!is_int($error) || !in_array($k, $range, true)) {
                 throw new RuntimeException("[{$k}] パラメータが不正です");
             }
             
             // ファイルが既に存在しているかどうかチェックする
             if (is_file("{$dir}/{$k}")) {
                 throw new RuntimeException("[{$k}] ファイルが既に存在しています");
             }
  
             // $_FILES['upfile']['error'][$k] の値を確認
             switch ($error) {
                 case UPLOAD_ERR_OK: // OK
                     break;
                 case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                     continue 2;
                 case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
                 case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過
                     throw new RuntimeException("[{$k}] ファイルサイズが大きすぎます");
                 default:
                     throw new RuntimeException("[{$k}] その他のエラーが発生しました");
             }
             
             // $_FILES['upfile']['mime']の値はブラウザ側で偽装可能なので
             // MIMEタイプを自前でチェックする
             if (!in_array(
                 @exif_imagetype($_FILES['upfile']['tmp_name'][$k]),
                 array(
                     IMAGETYPE_GIF,
                     IMAGETYPE_JPEG,
                     IMAGETYPE_PNG,
                 ),
                 true
             )) {
                 throw new RuntimeException("[{$k}] 画像形式が未対応です");
             }
             
             // キー番号をファイル名にして保存する
             if (!move_uploaded_file($_FILES['upfile']['tmp_name'][$k], "{$dir}/{$k}")) {
                 throw new RuntimeException("[{$k}] ファイル保存時にエラーが発生しました");
             }
             
             $msgs[] = array('green', "[{$k}] 保存しました");
  
         } catch (RuntimeException $e) {
  
             $msgs[] = array('red', $e->getMessage());
  
         }
     
     }
     
 } elseif (isset($_POST['resetfile']) && is_array($_POST['resetfile'])) {
     
     // 各ファイルをチェック
     foreach ($_POST['resetfile'] as $k => $dummy) {
         
         try {
             
             // 想定外のキーであれば不正とする
             $k = (int)$k;
             if (!in_array($k, $range, true)) {
                 throw new RuntimeException("[{$k}] パラメータが不正です");
             }
             
             // 存在しているかどうかチェックする
             if (!is_file("{$dir}/{$k}")) {
                 throw new RuntimeException("[{$k}] ファイルが存在しません");
             }
             
             // 削除する
             if (!unlink("{$dir}/{$k}")) {
                 throw new RuntimeException("[{$k}] 削除に失敗しました");
             }
             
             $msgs[] = array('green', "[{$k}] 削除しました");
  
         } catch (RuntimeException $e) {
  
             $msgs[] = array('red', $e->getMessage());
  
         }
         
     }
     
 }
  
 // XHTMLとしてブラウザに認識させる
 // (IE8以下はサポート対象外ｗ)
 header('Content-Type: application/xhtml+xml; charset=utf-8');
  
 ?>
 <!DOCTYPE html>
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>画像アップロード＆削除</title>
 </head>
 <body>
 <?php if (!empty($msgs)): ?>
   <ul>
 <?php foreach ($msgs as $msg): ?>
     <li style="color:<?=$msg[0]?>;"><?=$msg[1]?></li>
 <?php endforeach; ?>
   </ul>
 <?php endif; ?>
   <form enctype="multipart/form-data" method="post" action="">
     <fieldset>
       <legend>画像ファイルを選択 <input type="submit" name="uploadfile" value="アップロード" /></legend>
 <?php foreach ($range as $k): ?>
       <p>
 <?php if ($k): ?>
         <hr />
 <?php endif; ?>
         画像 <?=$k?><br />
 <?php if (!is_file("{$dir}/{$k}")): ?>
         <input type="file" name="upfile[<?=$k?>]" /><br />
 <?php else :?>
         <img src="<?="{$dir}/{$k}"?>" alt="画像<?=$k?>" /><br />
         <input type="submit" name="resetfile[<?=$k?>]" value="削除" /><br />
 <?php endif; ?>
       </p>
 <?php endforeach; ?>
     </fieldset>
   </form>
 </body>
 </html>
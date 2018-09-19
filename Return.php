<?php
session_start();

// エラーメッセージの初期化
$errorMessage = "";

 $errorMassage = "パスワードの再発行が完了しました。ログイン画面にお戻りください。";

 //セッションクリア
 @session_destroy();

 ?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>パスワード再発行完了</title>
  </head>
  <body>
    <h1>パスワード再発行完了画面</h1>
    <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
    <ul>
      <li><a href="Login.php">ログイン画面に戻る</a></li>
    </ul>
  </body>
</html>

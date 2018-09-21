<?php
session_start();

// エラーメッセージの初期化
$errorMessage = "";

 $errorMessage = "アカウントの登録が完了しました。TOP画面にお戻りください。";

 //セッションクリア
 @session_destroy();

 ?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>アカウント登録完了</title>
  </head>
  <body>
    <h1>アカウント登録完了画面</h1>
    <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
    <ul>
      <li><a href="Login.php">ログイン画面に戻る</a></li>
    </ul>
  </body>
</html>

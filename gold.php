<?php

session_start();
//DBの設定した内容
define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');

// エラーメッセージの初期化
$errorMessage = "";
// エスケープ処理
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


    $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));

    $sql = 'SELECT UserId,Gold FROM user WHERE UserId = 4 ';
    $value = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    $gold = (int)$value["Gold"];
  echo "\n--プリペアードステートメント--\n\n";

  var_dump($gold);
  ?>

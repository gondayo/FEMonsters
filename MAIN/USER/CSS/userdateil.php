<?php
require 'Password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();

define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');

try {
    $dbh = new PDO($dns, $user, $password,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    if ($dbh == null) {
        print_r('接続失敗').PHP_EOL;
    } else {
        print_r('接続成功').PHP_EOL;
    }
} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();

    $sql = 'SHOW TABLES';
    $stmt = $dbh->query($sql);

    while ($result = $stmt->fetch(PDO::FETCH_NUM)){
        $table_names[] = $result[0];
    }

    $table_data = array();
    foreach ($table_names as $key => $val) {
        $sql2 = "SELECT * FROM $val;";
        $stmt2 = $dbh->query($sql2);
        $table_data[$val] = array();
        while ($result2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
            foreach ($result2 as $key2 => $val2) {
                $table_data[$val][$key2] = $val2;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ユーザー詳細</title>
</head>
<body>

<ul>
  <?php
    foreach ($table_data as $key => $val){
      ?>

<p style="display:inline">ユーザー名：<span class = "UserName"><?php echo $users["UserName"];?></span></p>
<p style="display:inline">HP:<span class = "HitPoint"><?php echo $users["HitPoint"];?></span></p>
<p style="display:inline">お金:<span class = "Gold"><?php echo $users["Gold"];?></span></p>

<?php

}  ?>
</ul>
<a href="Logout.php">ログアウト</a>
<a href="main.php">ゲームへ戻る</a>
</body>
</html>

<?php
session_start();

//DBの設定した内容
define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');

// エラーメッセージの初期化
$errorMessage = "";

// ユーザー情報をすべて表示する
try {
  $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
    $UserName = $_SESSION["NAME"];
    $stmt = $pdo->prepare('SELECT UserName,HitPoint,Gold FROM user WHERE UserName = ?');
    $stmt->bindvalue(1,$UserName);
    $stmt->execute();

    $User=$stmt->fetch(PDO::FETCH_ASSOC);

  } catch (Exception $e) {
 $errorMessage = $e->getMessage();
}

// ログイン状態チェック
/*if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}

*/
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
  <a href="/MAIN/USER/PHP/userdateil.php">ユーザー名：<?php echo htmlspecialchars($User["UserName"], ENT_QUOTES, 'UTF-8');?> </a>
  <p style="display:inline">HP:<?php echo htmlspecialchars($User["HitPoint"], ENT_QUOTES, 'UTF-8');?></p>
  <p style="display:inline">お金:<?php echo htmlspecialchars($User["Gold"], ENT_QUOTES, 'UTF-8');?></p>
</ul>
<a href="/MAIN/Logout.php">ログアウト</a>
<a href="/MAIN/main.php">ゲームへ戻る</a>
</body>
</html>

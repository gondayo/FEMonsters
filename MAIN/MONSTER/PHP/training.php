<?php
session_start();

//DBの設定した内容
define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');

// エラーメッセージの初期化
$errorMessage = "";

try {

  $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
  $stmta = $pdo->prepare('SELECT UserId FROM user WHERE Auth = ?');
  $stmta->bindvalue(1,$_SESSION["UID"]);
  $stmta->execute();
  $UserId = $stmta->fetch(PDO::FETCH_ASSOC);
  $stmt = $pdo->prepare('SELECT * FROM u_monster WHERE UserId = ? ORDER BY MonsterId ASC');
  $stmt->bindvalue(1,(int)$UserId["UserId"],PDO::PARAM_INT);
  $stmt->execute();

} catch (Exception $e) {
  $errorMessage = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Training</title>
</head>
<body>
  <p><?php echo htmlspecialchars($Monsters["UserId"], ENT_QUOTES, 'UTF-8');?></p>
  <script src="<?php echo htmlspecialchars($Monsters["MonsterPic"], ENT_QUOTES, 'UTF-8');?>" charset="utf-8"></script>

</body>
</html>

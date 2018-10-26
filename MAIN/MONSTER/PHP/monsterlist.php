<?php
session_start();

//DBの設定した内容
define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');

// エラーメッセージの初期化
$errorMessage = "";

// モンスター情報をすべて表示する
try {
$pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
  $UserName = $_SESSION["NAME"];
  $stmta = $pdo->prepare('SELECT UserId FROM user WHERE UserName = ?');
  $stmta->bindvalue(1,$UserName);
  $stmta->execute();
  $monster = $stmta->fetch(PDO::FETCH_ASSOC);
  $stmt = $pdo->prepare('SELECT * FROM u_monster JOIN monster_library WHERE UserId = ? ORDER BY monsterId ASC');
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>monsterlist</title>
</head>
<link rel="stylesheet" type="text/css" href="/MAIN/MONSTER/CSS/monsterlist.css">
<body>

  <div class="mons_link">
    <div class="mons_img">
      <a href="monsterdateil.html">
        <img src="<?php echo htmlspecialchars($monster["MonsterPic"], ENT_QUOTES, 'UTF-8');?>" height="100px" width="100px" alt="モンスター画像" >
      </a>
  </div>
  <div class="mons_name">
    <a href="monsterdateil.html"class="mons_name_a">
      <?php echo htmlspecialchars($monster["MonsterId"], ENT_QUOTES, 'UTF-8');?>
      <?php echo htmlspecialchars($monster["MonsterName"], ENT_QUOTES, 'UTF-8');?>
    </a>
  </div>

</div>
</body>
</html>

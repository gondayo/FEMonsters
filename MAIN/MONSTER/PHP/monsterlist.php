<?php
session_start();

//DBの設定した内容
define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');

// エラーメッセージの初期化
$errorMessage = "";

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// モンスター情報をすべて表示する
try {
$pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));

  $stmt = $pdo->prepare('SELECT * FROM u_monster INNER JOIN monster_library ON u_monster.MonsterId = monster_library.MonsterId WHERE UserId = ? ORDER BY MonsterId ASC');
  $stmt->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
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
</head>
<link rel="stylesheet" type="text/css" href="/MAIN/MONSTER/CSS/monsterlist.css">
<body>

  <?php var_dump($Monsters["MonsterName"])?>
<ul>

  <?php
    foreach ($stmt as $Monsters){
      ?>
     <li>
       <img src="<?php echo h($Monsters["MonsterPic"]);?>" alt="モンスター画像">
       <span><?php echo h($Monsters["MonsterName"]);?></span>
     </li>
  <?php
    }
  ?>
  </ul>

</body>
</html>

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
  $stmt = $pdo->prepare('SELECT * FROM u_monster WHERE UserId = ? ORDER BY MonsterId ASC');
  $stmt->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
  $stmt->execute();

  $sql = "SELECT * FROM monster_library";
  $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
/*$pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
  $stmtb = $pdo->prepare('SELECT * FROM monster_library');
  $stmtb->value(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
  $stmtb->execute();
*/
  $array_mons_list = json_encode($rows, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
  $errorMessage = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link href="/MAIN/MONSTER/CSS/training.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="/MAIN/MONSTER/JS/training.js"></script>
  <title>Training</title>
  <script type="text/javascript">
  let mons_list = <?php echo $array_mons_list; ?>;
  </script>
</head>
<body>
<input type="image" id="monscheck" src="/MAIN/MONSTER/MONSTERPIC/a.png"name="monster" alt="モンスター">
<button id = "levelchek" type="button" name="level">レベルアップ</button>
<button id = "evocheck" type="button" name="button">進化</button>
<p>モンスター詳細</p>
<form method="POST">
 <div id="modal-main">
 </div>
</form>
</body>
</html>

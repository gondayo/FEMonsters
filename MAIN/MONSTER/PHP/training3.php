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

try {
  $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
  $stmt = $pdo->prepare('SELECT * FROM u_monster LEFT OUTER JOIN monster_library ON u_monster.MonsterId = monster_library.MonsterId WHERE UserId = ? ORDER BY u_monster.MonsterId ASC');
  $stmt->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
  $stmt->execute();

  //  $monster_json = jsone_encord($monster, JSON_UNESCAPED_UNICODE);
  $st = $pdo->prepare('SELECT * FROM monster_library WHERE MonsterId = ?');
  $st->bindvalue(1,(int)$_SESSION["currentmonster"],PDO::PARAM_INT);
  $st->execute();
  $cmonster = $st->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  $errorMessage = $e->getMessage();
}
  if(isset($_POST["monslist"])){
    try {
          $_SESSION["currentmonster"] = $_POST["monslist"];
          $st = $pdo->prepare('SELECT * FROM monster_library WHERE MonsterId = ?');
          $st->bindvalue(1,(int)$_SESSION["currentmonster"],PDO::PARAM_INT);
          $st->execute();
          $cmonster = $st->fetch(PDO::FETCH_ASSOC);
          header("Location: mcheck.php");
        } catch (Exception $e) {
          $errorMessage = $e->getMessage();
        }

  }



  ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <link href="../CSS/training.css" rel="stylesheet">
  <meta charset="UTF-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="../JS/training.js"></script>
  <title>Training</title>
  <script type="text/javascript">
  let mons_list = <?php echo $array_mons_list; ?>;
  </script>
</head>
<body>
  <div class="relative">
 <img src="/PICTURE/monsterbackground.png" alt="">
 <input type="image" id="monscheck" src="/MAIN/MONSTER/MONSTERPIC/a.png" name="monster" alt="モンスター">
 <div class="levelup">
    <img src="/PICTURE/levelup.png" alt="レベルアップ" id="login">
 </div>
 <div class="evolution">
 <img src="/PICTURE/evolution.png" alt="">
 </div>
 <span ><img id="currentmonster" src="<?php echo h($cmonster["MonsterPic"]);?>">
 <p>モンスター詳細</p></span>
 <form method="POST">
 <div id="modal-main">
   <h1>確認</h1>
   <ul>
     <?php
     $x = 1;
     foreach($stmt as $monsters){
       ?>
       <li>

         <img id="mons<?php echo h($x);?>"src="<?php echo h($monsters["MonsterPic"]);?>" alt="モンスター画像<?php echo h($x);?>">
         <button type="submit" id="button<?php echo h($x);?>" class="monslist" name="monslist" value="<?php echo h($x);?>">決定</button>
    <?php
    $x++;
    $y++;
       }

       ?>
    </ul>

 </div>
</form>



</body>
</html>

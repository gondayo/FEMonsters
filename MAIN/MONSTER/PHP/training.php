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
  $stmt = $pdo->prepare('SELECT * FROM u_monster LEFT OUTER JOIN monster_library ON u_monster.MonsterId = monster_library.MonsterId WHERE UserId = ? ORDER BY Flag ASC');
  $stmt->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
  $stmt->execute();


  //  $monster_json = jsone_encord($monster, JSON_UNESCAPED_UNICODE);
  $st = $pdo->prepare('SELECT * FROM monster_library WHERE MonsterId = ?');
  $st->bindvalue(1,(int)$_SESSION["currentmonster"],PDO::PARAM_INT);
  $st->execute();
  $cmonster = $st->fetch(PDO::FETCH_ASSOC);

  $sm = $pdo->prepare('SELECT MonsterLevel FROM u_monster WHERE UserId = ? AND MonsterId = ?');
  $sm->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
  $sm->bindvalue(2,(int)$_SESSION["currentmonster"],PDO::PARAM_INT);
  $sm->execute();
  $monsterlevel = $sm->fetch(PDO::FETCH_ASSOC);

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

          $sm = $pdo->prepare('SELECT MonsterLevel FROM u_monster WHERE UserId = ? AND MonsterId = ?');
          $sm->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
          $sm->bindvalue(2,(int)$_SESSION["currentmonster"],PDO::PARAM_INT);
          $sm->execute();
          $monsterlevel = $sm->fetch(PDO::FETCH_ASSOC);
          header("Location: mcheck.php");
        } catch (Exception $e) {
          $errorMessage = $e->getMessage();
        }

  }

  if(isset($_POST["levelup"])){
    try {
      $level = (int)$_POST["levelup"];
      if($level < 10){
      $level++;
      $stmt = $pdo->prepare('UPDATE u_monster SET MonsterLevel = ? WHERE UserId = ? AND MonsterId = ?');
      $stmt->bindvalue(1,(int)$level,PDO::PARAM_INT);
      $stmt->bindvalue(2,(int)$_SESSION["UID"],PDO::PARAM_INT);
      $stmt->bindvalue(3,(int)$_SESSION["currentmonster"],PDO::PARAM_INT);
      $stmt->execute();
      header("Location: levelcheck.php");
    }else{
      throw new Exception('これ以上レベルを上げることが出来ません。');
    }
    } catch (Exception $e) {
      $errorMessage = $e->getMessage();
    }
  }

  if(isset($_POST["evolution"])){
    try {
      $evolution = (int)$_POST["evolution"];
      if($evolution < 7){
        $evolution += 3;
        $stmt = $pdo->prepare('UPDATE u_monster SET MonsterId = ? WHERE UserId = ? AND MonsterId = ?');
        $stmt->bindvalue(1,(int)$evolution,PDO::PARAM_INT);
        $stmt->bindvalue(2,(int)$_SESSION["UID"],PDO::PARAM_INT);
        $stmt->bindvalue(3,(int)$_SESSION["currentmonster"],PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION["currentmonster"] = $evolution;
        header("Location: evocheck.php");
      }else{
        throw new Exception('これ以上進化することが出来ません。');
      }
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
</head>
<body>

  <div class="relative">
  <div id="error"><font color="#ff0000"><?php echo h($errorMessage); ?></font></div>
 <img src="/PICTURE/monsterbackground.png" alt="">
 <input type="image" id="monscheck" src="/MAIN/MONSTER/MONSTERPIC/a.png" name="monster" alt="モンスター">
<form method="post">
 <div class="levelup">
    <input type="image" src="/PICTURE/levelup.png" alt="レベルアップ">
    <input type="hidden" name="levelup" value="<?php echo h($monsterlevel["MonsterLevel"]);?>">
 </div>
</form>
<form  method="post">
 <div class="evolution">
   <input type="image"  src="/PICTURE/evolution.png" alt="進化">
   <input type="hidden" name="evolution" value="<?php echo h($_SESSION["currentmonster"]);?>">
 </div>
</form>
 <span><img id="<?php echo h($cmonster["CurrentMonster"]);?>" class="currentmonster" src="<?php echo h($cmonster["MonsterPic"]);?>"></span>
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

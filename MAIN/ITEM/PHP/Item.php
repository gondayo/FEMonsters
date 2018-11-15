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

// ユーザのアイテム情報をすべて表示する
try {
<<<<<<< HEAD
  $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
  $UserName = $_SESSION["NAME"];
  $stmta = $pdo->prepare('SELECT UserId FROM user WHERE UserName = ?');
  $stmta->bindvalue(1,$UserName);
=======
$pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
  $Auth = $_SESSION["UID"];
  $stmta = $pdo->prepare('SELECT UserId FROM user WHERE Auth = ?');
  $stmta->bindvalue(1,$Auth);
>>>>>>> a796fb265b46c0ec6fb96c9b52c02397dda301a4
  $stmta->execute();
  $UserId = $stmta->fetch(PDO::FETCH_ASSOC);
  $stmt = $pdo->prepare('SELECT * FROM u_item WHERE UserId = ? ORDER BY ItemId ASC');
  $stmt->bindvalue(1,(int)$UserId["UserId"],PDO::PARAM_INT);
  $stmt->execute();

} catch (Exception $e) {
  $errorMessage = $e->getMessage();
}

// ユーザのアイテム使用処理

  if (isset($_POST["ok"])){

    //モーダルとクリックされたアイテム名の改ざん検知的なことをしたかった
    //if($_POST["ItemName"] === $_POST["data-name"]){
      $ItemName = $_POST["ItemName"];

      function check($ItemNum){
        if($ItemNum === 0){
          throw new Exception('アイテムの所持数がありません。');
        }
      }

    try {
      $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));

      //アイテム名とアイテムIDで指定した個数を取得
      $stmta = $pdo->prepare('SELECT ItemNum FROM u_item WHERE ItemName = ? AND UserId = ?');
      $stmta->bindvalue(1,$ItemName);
      $stmta->bindvalue(2,(int)$UserId["UserId"],PDO::PARAM_INT);
      $stmta->execute();
      $ItemNum = $stmta->fetchAll(PDO::FETCH_COLUMN,0);
      check($ItemNum);
      $ItemNum = --$ItemNum;

      //アイテム個数を減らす
      $stmt = $pdo->prepare('UPDATE u_item SET ItemNum = ? WHERE ItemName = ? AND UserId = ?');
      $stmt->bindvalue(1,(int)$ItemNum,PDO::PARAM_INT);
      $stmt->bindvalue(2,$ItemName);
      $stmt->bindvalue(3,(int)$UserId["UserId"],PDO::PARAM_INT);
      $stmt->execute();
      //この時点でアイテム使用フラグをu_itemに送りダンジョンクリア後にフラグ消去のほうが良い？

      header("Location: Itemcheck.php");
        } catch (Exception $e) {
          $errorMessage = $e->getMessage();
      }

    /*}else{
    // セッションの変数のクリア
    $_SESSION = array();

    // セッションクリア
    @session_destroy();
  }*/
}
 ?>

<!doctype html>
<html>
 <head>
   <meta charset="UTF-8">
   <link href="/MAIN/ITEM/CSS/Item.css" rel="stylesheet">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="/MAIN/ITEM/JS/Item.js"></script>
 </head>
 <body>

   <ul>
   <?php
    foreach ($stmt as $Items){
<<<<<<< HEAD
   ?>
    <li>
        <span class="ItemName"><?php echo htmlspecialchars($Items["ItemName"], ENT_QUOTES, 'UTF-8');?></span>
        <span class="ItemNum"><?php echo htmlspecialchars($Items["ItemNum"], ENT_QUOTES, 'UTF-8');?></span>
        <button class="use" data-name="<?php echo htmlspecialchars($Items["ItemName"], ENT_QUOTES, 'UTF-8');?>" data-num="<?php echo htmlspecialchars($Items["ItemNum"], ENT_QUOTES, 'UTF-8');?>"value="<?php echo htmlspecialchars($Items["ItemId"], ENT_QUOTES, 'UTF-8');?>">使う</button>
    </li>
   <?php
    }
   ?>
=======
      ?>
    <li><span class="ItemName"><?php echo h($Items["ItemName"]);?></span>
        <span class="ItemNum"><?php echo h($Items["ItemNum"]);?></span><span>個</span>
        <button type="submit" class="use" data-name="<?php echo h($Items["ItemName"]);?>" data-num="<?php echo h($Items["ItemNum"]);?>">使う</button>
    </li>
   <?php
    }
      ?>
    </ul>
>>>>>>> a796fb265b46c0ec6fb96c9b52c02397dda301a4

  <form method="POST">
   <div id="modal-window">
     <span id="UseItem"></span><span class="check">を使用しますか？</span>
     <span id="UseNum" name="UseNum"></span><span class="check">個</span>
     <input id="Name" type="hidden" name="ItemName" value="">
   </div>
  </form>
 </body>
</html>

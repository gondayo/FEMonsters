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

  $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
  /*$stmta = $pdo->prepare('SELECT UserId FROM user WHERE Auth = ?');
  $stmta->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
  $stmta->execute();
  $UserId = $stmta->fetch(PDO::FETCH_ASSOC);*/
  $stmt = $pdo->prepare('SELECT * FROM u_item WHERE UserId = ? AND ItemFlag = 1 ORDER BY ItemId ASC');
  //$stmt->bindvalue(1,(int)$UserId["UserId"],PDO::PARAM_INT);
  $stmt->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
  $stmt->execute();

  $st = $pdo->prepare('SELECT * FROM u_item WHERE UserId = ? AND ItemFlag = 0 ORDER BY ItemId ASC');
  //$st->bindvalue(1,(int)$UserId["UserId"],PDO::PARAM_INT);
  $st->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
  $st->execute();

} catch (Exception $e) {
  $errorMessage = $e->getMessage();
}

// ユーザのアイテム使用処理

  if (isset($_POST["ok"])){

    //モーダルとクリックされたアイテム名の改ざん検知的なことをしたかった
    //if($_POST["ItemName"] === $_POST["data-name"]){
      $ItemName = $_POST["ItemName"];

      /*function check($ItemNum){

      }*/

    try {
      $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));

      //アイテム名とアイテムIDで指定した個数を取得
      $stmta = $pdo->prepare('SELECT ItemNum FROM u_item WHERE ItemName = ? AND UserId = ?');
      $stmta->bindvalue(1,$ItemName);
      $stmta->bindvalue(2,(int)$_SESSION["UID"],PDO::PARAM_INT);
      $stmta->execute();
      $ItemNum = $stmta->fetch(PDO::FETCH_ASSOC);
      if($ItemNum["ItemNum"] > 0){
        $ItemNum["ItemNum"] = --$ItemNum["ItemNum"];

        //アイテム個数を減らす
        $stmt = $pdo->prepare('UPDATE u_item SET ItemNum = ? WHERE ItemName = ? AND UserId = ?');
        $stmt->bindvalue(1,(int)$ItemNum["ItemNum"],PDO::PARAM_INT);
        $stmt->bindvalue(2,$ItemName);
        $stmt->bindvalue(3,(int)$_SESSION["UID"],PDO::PARAM_INT);
        $stmt->execute();
        //この時点でアイテム使用フラグをu_itemに送りダンジョンクリア後にフラグ消去のほうが良い？

        header("Location: Itemcheck.php");

        }else{
          throw new Exception('アイテムの所持数がありません。');
        }
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

<div id="error"><font color="#ff0000"><?php echo h($errorMessage); ?></font></div>

  <ul class="tab cf">
    <li class="type tab1 tab_current">スキルアイテム</li>
    <li class="type tab2">進化アイテム</li>
    <ul class="contents">
    <li class="ChangeElem_Panel">
      <div class="itemlist">
        <ul>
          <?php
          $x = 0;
          foreach ($stmt as $Items){
            ?>
            <li id="list<?php echo h($x);?>"><span class="itemname<?php echo h($x);?>"><?php echo h($Items["ItemName"]);?></span>
              <span class="itemnum<?php echo h($x);?>"><?php echo h($Items["ItemNum"]);?></span><span class ="k<?php echo h($x);?>">個</span>
              <button class="use" data-flag="<?php echo h($Items["ItemFlag"]);?>"data-name="<?php echo h($Items["ItemName"]);?>" data-num="<?php echo h($Items["ItemNum"]);?>"></button>
            </li>
          <?php
            $x++;
          }
          ?>
        </ul>
      </div>
    </li>
    <li class="ChangeElem_Panel">
      <div class="itemlist">
        <ul>
          <?php
          $x = 0;
          foreach ($st as $Items){
            ?>
            <li id="lt<?php echo h($x);?>"><span class="itemname<?php echo h($x);?>"><?php echo h($Items["ItemName"]);?></span>
              <span class="itemnum<?php echo h($x);?>"><?php echo h($Items["ItemNum"]);?></span><span class="k<?php echo h($x);?>">個</span>
              <button class="use" data-flag="<?php echo h($Items["ItemFlag"])?>"data-name="<?php echo h($Items["ItemName"]);?>" data-num="<?php echo h($Items["ItemNum"]);?>"></button>
            </li>
          <?php
            $x++;
          }
          ?>
        </ul>
      </div>
    </li>
  <form method="POST">
   <div id="modal-window">

     <input id="name" type="hidden" name="ItemName" value="">
   </div>
  </form>
 </body>
</html>

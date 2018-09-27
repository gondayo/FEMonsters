<?php

session_start();
//DBの設定した内容
define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');

// エラーメッセージの初期化
$errorMessage = "";

// ユーザのアイテム情報をすべて表示する
try {
$pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
  $stmt= $pdo->prepare('SELECT * FROM u_item WHERE UserId = 1');
  //$stmt= $pdo->prepare('SELECT * FROM u_item WHERE UserId = ?');
  //$stmt->bindvalue(1.$UserId);
  $stmt->execute();

  } catch (Exception $e) {
    $errorMessage = $e->getMessage();
  }
// ユーザのアイテム使用処理
/*if (isset($_POST["ok"])){
  //1
  //if($_POST["ItemNum"] === 0){
   //$errorMessage = 'アイテムの所持数がありません';

  $ItemNum = "";
  $ItemId = "";

  function check($ItemNum){
    if($ItemNum === 0){
      throw new Exception('アイテムの所持数がありません。');
    }
  }
  //$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

  try {
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
    check($ItemNum);
    $ItemNum = $ItemNum - 1;

    $stmt = $pdo->prepare('UPDATE u_item SET ItemNum = ?');
    $stmt->bindvalue(1,(int)$ItemNum,PDO::PARAM_INT);
    $stmt->execute();
    //この時点でアイテム使用フラグをu_itemに送りダンジョンクリア後にフラグ消去のほうが良い？
    $stmt = $pdo->prepare('SELECT * FROM item_library WHERE ItemId = ?');
    $stmt->bindvalue(1,(int)$ItemId,PDO::PARAM_INT);
    $stmt->execute();

    //以下条件分岐で効果を変える処理
  } catch (Exception $e) {
    $errorMessage = $e->getMessage();
  }
}*/
 ?>

<!doctype html>
<html>
 <head>
   <meta charset="UTF-8">
   <link href="Manual.css" rel="stylesheet">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="Item.js"></script>
 </head>
 <body>
   <div id="modal-main">
     <p><?php echo $Items["ItemName"];?>を使用しますか？</p>
     <button id="ok">使う</button>
   </div>
   <ul>

   <?php

   foreach ($stmt as $Items){?>
     <li> <?php echo $Items["ItemName"];?>
          <?php echo $Items["ItemNum"];?>
         <button id="use" value=<?php echo $Items["ItemId"];?>>使う</button>
     </li>
   <?php } ?>

 </ul>
 </body>

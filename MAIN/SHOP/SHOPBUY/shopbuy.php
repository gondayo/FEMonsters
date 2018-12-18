<?php

session_start();
//DBの設定した内容
define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');

// エラーメッセージの初期化
$errorMessage = "";
// エスケープ処理
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
// ショップのアイテム情報をすべて表示する
try {
  $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));

    /*$Auth = $_SESSION["UID"];
    $stmta = $pdo->prepare('SELECT UserId FROM user WHERE Auth = ?');
    $stmta->bindvalue(1,$Auth);
    $stmta->execute();
    $UserId = $stmta->fetch(PDO::FETCH_ASSOC);*/
    $sql = "SELECT * FROM item_library WHERE ShopFlag = 1";
    $si= $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);

    $stmt = $pdo->prepare('SELECT UserId,Gold FROM user WHERE Auth = ?');
    $stmt->bindvalue(1,$_SESSION["UID"]);
    $stmt->execute();
    $value = $stmt->fetch(PDO::FETCH_ASSOC);
    $UserId = (int)$value["UserId"];
    $Gold = (int)$value["Gold"];

} catch (Exception $e) {
   $errorMessage = $e->getMessage();
}

  if (isset($_POST["itembuy"])){
    $buyname = $_POST["buyname"];
    $total = (int)$_POST["total"];
    $num = (int)$_POST["num"];


    try {
      if(!empty($_POST["num"])){

        if($Gold >= $total ){

          $Gold = $Gold - $total;

          $stmt = $pdo->prepare('UPDATE user SET Gold = ? WHERE UserId = ?');
          $stmt->bindvalue(1,(int)$Gold,PDO::PARAM_INT);
          $stmt->bindvalue(2,(int)$UserId,PDO::PARAM_INT);
          $stmt->execute();


          //アイテム名とアイテムIDで指定した個数を取得
          $stmta = $pdo->prepare('SELECT ItemNum FROM u_item WHERE ItemName = ? AND UserId = ?');
          $stmta->bindvalue(1,$buyname);
          $stmta->bindvalue(2,(int)$UserId,PDO::PARAM_INT);
          $stmta->execute();
          $ItemNum = $stmta->fetch(PDO::FETCH_ASSOC);
          $ItemNum["ItemNum"] += $num;
          $stmtb = $pdo->prepare('UPDATE u_item SET ItemNum = ? WHERE ItemName = ? AND UserId = ?');
          $stmtb->bindvalue(1,(int)$ItemNum["ItemNum"],PDO::PARAM_INT);
          $stmtb->bindvalue(2,$buyname);
          $stmtb->bindvalue(3,(int)$UserId,PDO::PARAM_INT);
          $stmtb->execute();

          header("Location: buycheck.php");

        }else{

          throw new Exception('所持金が足りません。');

        }
      }else{
        throw new Exception('個数を選択してください。');
      }


      } catch (Exception $e) {
        $errorMessage = $e->getMessage();
      }
  }
  ?>

  <!doctype html>
  <html>
   <head>
     <meta charset="UTF-8">
     <link href="../CSS/shopbuy.css" rel="stylesheet">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script src="../JS/shopbuy.js"></script>
   </head>
   <body>
     <div id="u_gold">
     <img src="../../../PICTURE/u_gold.png" />
     <span id="gold"><?php echo h($Gold);?> G</span>
     </div>

     <div id="error"><?php echo h($errorMessage); ?></div>
     <div id="shoplist">
     <ul>
     <?php
      foreach ($si as $SItems){
        ?>
      <li><span class="SItemName"><?php echo h($SItems["ItemName"]);?></span>
          <span class="SItemPrice"><?php echo h($SItems["Price"]);?></span><span>G</span>
          <button class="buy" data-name="<?php echo h($SItems["ItemName"]);?>" data-price="<?php echo h($SItems["Price"]);?>">買う</button>
      </li>
     <?php
      }
        ?>
     </ul>
     </div>
    <form method="POST">
     <div id="modal-window">

       <span id="buyname" name="buyname"></span><span class="check">を買いますか？</span>
       <select name="num">
         <option value="">選択してください</option>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
         <option value="6">6</option>
         <option value="7">7</option>
         <option value="8">8</option>
         <option value="9">9</option>
       </select>
       <span class="ko">個</span>
       <span id ="total"></span><span>Gold</span>
       <button type="submit" id="itembuy" name="itembuy">買う</button>

       <p class="iteminfo"></p>
       <input id="info1" type="hidden" name="buyname" value="">
       <input id="info2" type="hidden" name="total" value="">
       <input id="info3" type="hidden" name="num" value="">
     </div>
    </form>
   </body>
  </html>

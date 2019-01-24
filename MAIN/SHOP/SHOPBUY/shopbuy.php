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

    /*$Auth = (int)(int)$_SESSION["UID"],PDO::PARAM_INT,PDO::PARAM_INT;
    $stmta = $pdo->prepare('SELECT UserId FROM user WHERE Auth = ?');
    $stmta->bindvalue(1,$Auth);
    $stmta->execute();
    $UserId = $stmta->fetch(PDO::FETCH_ASSOC);*/
    $sql = "SELECT * FROM item_library WHERE ShopFlag = 1";
    $si= $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);

    $sql = "SELECT * FROM monster_library WHERE MShopFlag = 1";
    $sm= $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    //ユーザーの所持金を持ってくる
    //$stmt = $pdo->prepare('SELECT UserId,Gold FROM user WHERE Auth = ?');
    $stmt = $pdo->prepare('SELECT Gold FROM user WHERE UserId = ?');
    $stmt->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
    $stmt->execute();
    $value = $stmt->fetch(PDO::FETCH_ASSOC);
    //$UserId = (int)$value["UserId"];
    $Gold = (int)$value["Gold"];

    $stmt = $pdo->prepare('SELECT count(*) FROM u_monster WHERE UserId = ? AND MShopFlag = 1 AND MonsterId = 2');
    $stmt->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
    $stmt->execute();
    $Monster = $stmt->fetchColumn();
    $Monster2 = (int)$Monster;

    $stmt = $pdo->prepare('SELECT count(*) FROM u_monster WHERE UserId = ? AND MShopFlag = 1 AND MonsterId = 3');
    $stmt->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
    $stmt->execute();
    $Monster = $stmt->fetchColumn();
    $Monster3 = (int)$Monster;

} catch (Exception $e) {
   $errorMessage = $e->getMessage();
}

  if (isset($_POST["shopbuy"])){
    try {
      switch ($_POST["shopbuy"]) {

          case 1 :
            if(!empty($_POST["num1"])){
              $buyname = $_POST["buyname1"];
              $total = (int)$_POST["total1"];
              $num = (int)$_POST["num1"];
              if($Gold >= $total ){

                $Gold = $Gold - $total;

                $stmt = $pdo->prepare('UPDATE user SET Gold = ? WHERE UserId = ?');
                $stmt->bindvalue(1,(int)$Gold,PDO::PARAM_INT);
                $stmt->bindvalue(2,(int)$_SESSION["UID"],PDO::PARAM_INT);
                $stmt->execute();

                //アイテム名とアイテムIDで指定した個数を取得
                $stmt = $pdo->prepare('SELECT ItemNum FROM u_item WHERE ItemName = ? AND UserId = ?');
                $stmt->bindvalue(1,$buyname);
                $stmt->bindvalue(2,(int)$_SESSION["UID"],PDO::PARAM_INT);
                $stmt->execute();
                $ItemNum = $stmt->fetch(PDO::FETCH_ASSOC);
                $ItemNum["ItemNum"] += $num;
                $stmt = $pdo->prepare('UPDATE u_item SET ItemNum = ? WHERE ItemName = ? AND UserId = ?');
                $stmt->bindvalue(1,(int)$ItemNum["ItemNum"],PDO::PARAM_INT);
                $stmt->bindvalue(2,$buyname);
                $stmt->bindvalue(3,(int)$_SESSION["UID"],PDO::PARAM_INT);
                $stmt->execute();

                header("Location: buycheck.php");
                }else{

                  throw new Exception('所持金が足りません。');

                }
              }else{
                throw new Exception('個数を選択してください。');
              }


          case 2:
            if(!empty($_POST["num2"])){
              $buyname = $_POST["buyname2"];
              $total = (int)$_POST["total2"];
              $num = (int)$_POST["num2"];
              $id = (int)$_POST["id"];
              if($Monster2 == 0 && $id == 2 || $Monster3 == 0 && $id == 3){
                if($Gold >= $total ){

                  $Gold = $Gold - $total;

                  $stmt = $pdo->prepare('UPDATE user SET Gold = ? WHERE UserId = ?');
                  $stmt->bindvalue(1,(int)$Gold,PDO::PARAM_INT);
                  $stmt->bindvalue(2,(int)$_SESSION["UID"],PDO::PARAM_INT);
                  $stmt->execute();
                  //購入したモンスターを登録
                  $stmt = $pdo->prepare('INSERT INTO u_monster(UserId,MonsterId,MShopFlag) VALUES(?,?,1)');
                  $stmt->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
                  $stmt->bindvalue(2,(int)$id,PDO::PARAM_INT);
                  $stmt->execute();

                  header("Location: buycheck.php");
                }else{

                  throw new Exception('所持金が足りません。');
                }
                }else{

                  throw new Exception('このモンスターはすでに購入済みです。');
                }
              }else{
                throw new Exception('個数を選択してください。');
              }
              break;
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
     <span id="gold"><?php echo h($Gold);?> G</span>
     </div>

     <div id="error"><font color="#ff0000"><?php echo h($errorMessage); ?></font></div>
     <ul class="tab cf">
       <li class="type tab1 tab_current">1つめ</li>
       <li class="type tab2">2つめ</li>
       <ul class="contents">
       <li class="ChangeElem_Panel">
         <div class="shoplist">
           <ul>
             <?php
             $x = 0;
             foreach ($si as $SItems){

               ?>
              <li id="item<?php echo h($x);?>"><span class="shopname<?php echo h($x);?>"><?php echo h($SItems["ItemName"]);?></span>
               <span class="shopprice<?php echo h($x);?>"><?php echo h($SItems["Price"]);?></span><span class ="buyg<?php echo h($x);?>">G</span>
               <button class="buy0" data-name="<?php echo h($SItems["ItemName"]);?>" data-price="<?php echo h($SItems["Price"]);?>">買う</button>
              </li>
              <br>
              <?php
              $x++;
            }
            ?>
          </ul>
        </div>
   </li>
   <li class="ChangeElem_Panel">
     <div class="shoplist">
              <ul>
                <?php
                $x = 0;
                foreach ($sm as $SMonsters){

                  ?>
                 <li id="monster<?php echo h($x);?>"><span class="shopname<?php echo h($x);?>"><?php echo h($SMonsters["MonsterName"]);?></span>
                  <span class="shopprice<?php echo h($x);?>"><?php echo h($SMonsters["MPrice"]);?></span><span class ="buyg<?php echo h($x);?>">G</span>
                  <button class="buy1" data-id ="<?php echo h($SMonsters["MonsterId"]);?>" data-name="<?php echo h($SMonsters["MonsterName"]);?>" data-price="<?php echo h($SMonsters["MPrice"]);?>">買う</button>
                 </li>
                 <br>
                 <?php
                 $x++;
               }

               ?>
             </ul>
           </div>
         </li>
  </ul>
    <form method="POST">
     <div class="modal-window1">
       <h1>購入確認</h1>
       <span class="buyname" name="buyname"></span><span class="check">を買いますか？</span>
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
       <span class="total"></span><span>Gold</span>
       <button type="submit" class="shopbuy" name="shopbuy" value="1">買う</button>

       <p class="info"></p>
       <input class="info1" type="hidden" name="buyname1" value="">
       <input class="info2" type="hidden" name="total1" value="">
       <input class="info3" type="hidden" name="num1" value="">
     </div>
   </form>
   <form method="POST">
     <div class="modal-window2">
       <h1>購入確認</h1>
       <span class="buyname" name="buyname"></span><span class="check">を買いますか？</span>
       <select name="num">
         <option value="">選択してください</option>
         <option value="1">1</option>
       </select>
       <span class="ko">個</span>
       <span class="total"></span><span>Gold</span>
       <button type="submit" class="shopbuy" name="shopbuy" value="2">買う</button>

       <p class="info"></p>
       <input class="info4" type="hidden" name="buyname2" value="">
       <input class="info5" type="hidden" name="total2" value="">
       <input class="info6" type="hidden" name="num2" value="">
       <input class="info7" type="hidden" name="id" value="">
     </div>
    </form>
   </body>
  </html>

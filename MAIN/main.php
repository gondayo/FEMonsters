<?php
session_start();

//DBの設定した内容
define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');

// エラーメッセージの初期化
$errorMessage = "";

// ユーザー情報をすべて表示する
try {
  $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
    $UserName = $_SESSION["NAME"];
    $stmt = $pdo->prepare('SELECT UserName,HitPoint,Gold FROM user WHERE UserName = ?');
    $stmt->bindvalue(1,$UserName);
    $stmt->execute();

    $User=$stmt->fetch(PDO::FETCH_ASSOC);

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="manual.js"></script>
  <title>FEmonsters</title>
</head>
<link rel="stylesheet" type="text/css" href="/MAIN/main.css">
<body>
<header>
<div class="header" id="contents">
<tr>
  <a href="Logout.php">
    <img src="/PICTURE/shortlogo.png" alt="FEMonstars">
  </a>
  <a href="/MAIN/USER/PHP/userdateil.php">ユーザー名：<?php echo($User["UserName"]);?> </a>
</tr>
</div>
</header>
<div class="window">
  <div class="left">
    <div class="game">
      <object type="text/html" id = "map" data="/MAIN/MAP/HTML/Map.html"></object>
    </div>
  </div>
  <div class="right">
    <div id="grow">
      <div id="tabpage1">
        <object type="text/html" data="/MAIN/ITEM/PHP/Item.php" height="525px" width="100%"></object>
      </div>
      <div id="tabpage2">
        <object type="text/html" data="/MAIN/SHOP/SHOPBUY/shopbuy.php" height="525px" width="100%"></object>
      </div>
      <div id="tabpage3">
        <object type="text/html" data="/MAIN/MONSTER/PHP/training.php" height="525px" width="100%"></object>
      </div>
      <div id="tabpage4">…… タブ4の中身 ……</div>
    </div>
    <div id="cmbotton">
      <a href="#tabpage1"id=item>
        <img src="/PICTURE/itembutton.png" alt="ITEM">
      </a>
      <a href="#tabpage2"id=shop>
        <img src="/PICTURE/shopbutton.png" alt="SHOP">
      </a>
      <a href="#tabpage3"id=monster>
        <img src="/PICTURE/monsterbutton.png" alt="MONS">
      </a>
      <a href="#tabpage4"id=info>info</a>
  </div>
  </div>

</div>
  <script type="text/javascript">

     var tabs = document.getElementById('cmbotton').getElementsByTagName('a');
     var pages = document.getElementById('grow').getElementsByTagName('div');

     function changeTab() {
        // href属性値から対象のid名を抜き出す
        var targetid = this.href.substring(this.href.indexOf('#')+1,this.href.length);

        // 指定のタブページだけを表示する
        for(var i=0; i<pages.length; i++) {
           if( pages[i].id != targetid ) {
              pages[i].style.display = "none";
           }
           else {
              pages[i].style.display = "block";
           }
        }

        // クリックされたタブを前面に表示する
        for(var i=0; i<tabs.length; i++) {
           tabs[i].style.zIndex = "0";
        }
        this.style.zIndex = "10";

        // ページ遷移しないようにfalseを返す
        return false;
     }

     // すべてのタブに対して、クリック時にchangeTab関数が実行されるよう指定する
     for(var i=0; i<tabs.length; i++) {
        tabs[i].onclick = changeTab;
     }

     // 最初は先頭のタブを選択
     tabs[0].onclick();

  </script>

</body>

</html>

<?php
/*require '/TOP/LOGIN/PHP/Password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();
*/
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="Manual.js"></script>
  <title>FEmonsters</title>
</head>
<link rel="stylesheet" type="text/css" href="/MAIN/CSS/main.css">
<body>
<script src="main.js"></script>
<header>
  <div id="modal-main">
    <h1>Manual</h1>
    <p>aaa</p>
    <p>bbb</p>
    <p>ccc</p>
    <p>aaa</p>
    <p>bbb</p>
    <p>ccc</p>
    <p>aaa</p>
    <p>bbb</p>
    <p>ccc</p>
  </div>
<div class="header" id="contents">
<tr>
  <a href="Logout.php">FEmonsters</a>
  <p id="modal-open" style="display:inline;">Manual</p>
</tr>
</div>
</header>
<div class="users">
  <a href="userdateil.php">ユーザー名：<?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?> </a>
  <p style="display:inline">HP:<?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></p>
  <p style="display:inline">お金:<?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></p>
</div>
  <div class="left">
    <div class="game">
      <object type="text/html" data="Map.html"></object>
    </div>
  </div>
  <div class="right">
    <div id="grow">
      <div id="tabpage1">
        <object type="text/html" data="Item.php" height="525px" width="100%"></object>
      </div>
      <div id="tabpage2">
        <object type="text/html" data="shop.html" height="525px" width="100%"></object>
      </div>
      <div id="tabpage3">
        <object type="text/html" data="monsterlist.php" height="525px" width="100%"></object>
      </div>
      <div id="tabpage4">…… タブ4の中身 ……</div>
    </div>
    <div id="cmbotton">
      <a href="#tabpage1"id=item>アイテム</a>
      <a href="#tabpage2"id=shop>ショップ</a>
      <a href="#tabpage3"id=monster>モンスター</a>
      <a href="#tabpage4"id=info>info</a>
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

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
    $stmt = $pdo->prepare('SELECT UserName,HitPoint,Gold,Exp FROM user WHERE UserName = ?');
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
  <title>戦闘</title>
    <link rel="stylesheet" href="../CSS/buttle.css">
    <link type="text/css" rel="stylesheet"
      href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />

    <style type="text/css">
      #loading {
        position: absolute;
        left: 50%;
      }
    </style>

    <script type="text/javascript"
      src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript"
      src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript">
      $(function() {
      // プログレスバーを生成
        $('#progress').progressbar({
          value: 37,
          max: 100
        });

        var per =  $('#progress').progressbar('value') /
          $('#progress').progressbar('option', 'max')
        $('#loading').text(Math.ceil(per * 100) + '秒');

      // 何度も使うので、変数に退避
        var p = $('#progress');
        var l = $('#loading');
        p.progressbar({
          value: 100,
      // 値の変更をラベルにも反映
        change: function() {
          l.text(p.progressbar('value') + '秒');
        },
      // 完了時にダイアログボックスを表示
        complete: function() {
          window.alert('処理を完了しました！');
        }
        });

      // 1秒おきにプログレスバーを更新
        var id = setInterval(function() {
          var v = p.progressbar('value');
          p.progressbar('value', --v);
            if (v <= 0) { clearInterval(id) }
        }, 1000);

        });
    </script>
    <script src="../JS/buttle.js"></script>
</head>
<body>
  <div id="progress"></div>
    <div id="loading"></div>
  <progress id="lifeBar" value="0" max="100" min="0" optimum="100"></progress>
</body>
</html>

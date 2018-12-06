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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
    <script src="../JS/result.js"></script>
    <script type="text/javascript">
      $(function() {
      // プログレスバーを生成
        $('#progress').progressbar({
          value: 37,
          max: 90
        });

        var per =  $('#progress').progressbar('value') /
          $('#progress').progressbar('option', 'min')
        $('#loading').text(Math.ceil(per * 100) + '秒');

      // 何度も使うので、変数に退避
        var p = $('#progress');
        var l = $('#loading');
        p.progressbar({
          value: 90,
      // 値の変更をラベルにも反映
        change: function() {
          l.text(p.progressbar('value') + '秒');
        },

      // 完了時にダイアログボックスを表示
        /*complete: function() {
          window.alert('処理を完了しました！');
        }:*/
      });

      // 1秒おきにプログレスバーを更新
        var id = setInterval(function() {
          var v = p.progressbar('value');
          p.progressbar('value', --v);
            if (v <= 0) { clearInterval(id) }
        }, 100);

    });

    var hp = 20;
      $("#hit").text(hp);

    function damage(){
      if(hp>1){
        --hp;
      $("#hit").text(hp);

      }else{
        //modal
        $(function(){


              //body内の最後に<div id="modal-bg"></div>を挿入
             $("body").append('<div id="modal-bg"></div>');

            //画面中央を計算する関数を実行
            modalResize();

            //モーダルウィンドウを表示
                $("#modal-bg,#modal-main").fadeIn("slow");




            //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
             $(window).resize(modalResize);
              function modalResize(){

                    var w = $(window).width();
                  var h = $(window).height();

                    var cw = $("#modal-main").outerWidth();
                   var ch = $("#modal-main").outerHeight();

                //取得した値をcssに追加する
                    $("#modal-main").css({
                        "left": ((w - cw)/2) + "px",
                        "top": ((h - ch)/2) + "px"
                  });
             }

        });


      }

    }

    </script>
    <script src="../JS/buttle.js"></script>
</head>
<body>
  <div id="modal-main">
    <h1>Result</h1>
    <input type="button" name="" value="MAINへ戻る"　onclick="">
  </div>
  <p id="modal-open" >Result</p>
  <p>ユーザー:<?php echo htmlspecialchars($User["UserName"], ENT_QUOTES, 'UTF-8');?></p>
  <input type="button" id="text-button" value="-1" onClick="damage()">
  <p>HP:<span id= "hit">20</span></p>
  <div id="progress"></div>
    <div id="loading"></div>
  <progress id="lifeBar" value="0" max="80" min="0" optimum="80">
  </progress>
</body>
</html>

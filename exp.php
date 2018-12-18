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

//レベルアップ=スキルレベルアップ
//一定レベルでレベル上限　進化で上限突破
try {
  $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
  $sql = "SELECT * FROM exp_table";
  $exp = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);

  $level_key = array_keys($exp);

  $level_key_json = json_encode($level_key, JSON_UNESCAPED_UNICODE);
  $exp_json = json_encode($exp, JSON_UNESCAPED_UNICODE);

  } catch (Exception $e) {
     $errorMessage = $e->getMessage();
  }
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="exp.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<title>uwaaaaaaaaaaaa</title>
</head>
<body>
<script>
  var level_key_jq = <?php echo $level_key_json;?>;
  var exp_jq = <?php echo $exp_json;?>;
  var x = 0;
  var level = 1;
  var exp = 0;
  var exp2 = exp_jq[level_key_jq[x]].Exp2;

  $(function(){
        //画面のどこかをクリックしたらモーダルを閉じる
    $("#exit").click(function(){
      $("#exp-modal,#exp-modalbg").fadeOut("slow",function(){
        //挿入した<div id="modal-bg"></div>を削除
          $("#exp-modalbg").remove() ;
      });

    });
    $(".level").text(level);
    $("#exp").text(exp);
    $("#fushiginaame").on('click',function(){
      if(level<10) {
        exp += 100;
        $("#exp").text(exp);
        if(exp >= exp2) {

          //body内の最後に<div id="modal-bg"></div>を挿入
         $("body").append('<div id="exp-modalbg"></div>');

        //画面中央を計算する関数を実行
        modalResize();

        //モーダルウィンドウを表示
            $("#exp-modalbg,#exp-modal").fadeIn("slow");

        //画面のどこかをクリックしたらモーダルを閉じる
          $("#exit").click(function(){
              $("#exp-modal,#exp-modalbg").fadeOut("slow",function(){
             //挿入した<div id="modal-bg"></div>を削除
                  $("#exp-modalbg").remove() ;
             });

            });

        //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
         $(window).resize(modalResize);
          function modalResize(){

              var w = $(window).width();
              var h = $(window).height();

              var cw = $("#exp-modal").outerWidth();
              var ch = $("#exp-modal").outerHeight();

            //取得した値をcssに追加する
                $("#exp-modal").css({
                    "left": ((w - cw)/2) + "px",
                    "top": ((h - ch)/2) + "px"
              });
         }

          level++;
          x++;
          exp2 = exp_jq[level_key_jq[x]].Exp2;
          $(".level").text(level);
        }
      }else{
        $("#happy").after('<p>happy☆end</p>')
      }
    });
  });




</script>
<!--試作案
    ボタンを押して経験値取得　一定値でレベルアップイベント発火
    モーダルウィンドウ表示　モーダル閉じたらレベル・経験値標記変更
-->
  <button id="fushiginaame">ふしぎな粉</button>
  <p id="happy">気分が高揚するふしぎな粉</p>
  <p><span class="level"></span>lv</p>
  <p><span id="exp"></span>exp</p>
  <div id="exp-modal">
  <p>レベルアップ！</p>
  <p><span class="level"></span>lv</p>
  <button id="exit">戻る</button>
  </div>
</body>
</html>

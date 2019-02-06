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

try {
  $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));

  // 問題を取ってくる
  $sql = "SELECT Tec_QuestionNo, Tec_QuestionText, Tec_Choices1, Tec_Choices2, Tec_Choices3, Tec_Choices4 FROM tec_dungeon  WHERE Tec_Id = 1";
  $question = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
  // 問題番号シャッフル
  $array_key = array_keys($question);
  shuffle($array_key);

  $_SESSION["ANS"] = 0;
  $array_key_json = json_encode($array_key, JSON_UNESCAPED_UNICODE);
  $question_json = json_encode($question, JSON_UNESCAPED_UNICODE);

 } catch (Exception $e) {
    $errorMessage = $e->getMessage();
}

//モータルウィンドウ用画面遷移　
if(isset($_POST["mainback"])){
  header("Location: /MAIN/main.php");
  exit();
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="../CSS/quiz.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../JS/tec_quiz2.js"></script>
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
<script src="../JS/menu.js"></script>
<script type="text/javascript">

//phpから問題を受け取る
let array_key_jq = <?php echo $array_key_json; ?>;
let question_jq = <?php echo $question_json; ?>;

//問題数
var x = 0;
//正答数
var y = 0;
//最大問題数
var r = 0;
//HP
var hp = 2;
  $("#hit").text(hp);
  $("#no").text(x);
//不正解数
var z = 0;

//gold
var gold = 0;
//exp
var exp = 0;

//問題表示
let title = question_jq[array_key_jq[x]].Tec_QuestionText;
let choices = [question_jq[array_key_jq[x]].Tec_Choices1, question_jq[array_key_jq[x]].Tec_Choices2, question_jq[array_key_jq[x]].Tec_Choices3, question_jq[array_key_jq[x]].Tec_Choices4];
var ans = choices[0];

  //選択肢シャッフル
for (let i = choices.length - 1; i >= 0; i--){

  // 0~iのランダムな数値を取得
  var rand = Math.floor( Math.random() * ( i + 1 ) );

  // 配列の数値を入れ替える
  [choices[i], choices[rand]] = [choices[rand], choices[i]]

}

$(function() {

  timeAct();

  $("h2").text(title);
  $("#choices1").val(choices[0]);
  $("#choices2").val(choices[1]);
  $("#choices3").val(choices[2]);
  $("#choices4").val(choices[3]);

  $(".choice").on('click',function() {
    stopTimer();
    //$( "#progress" ).progressbar( "destroy" );

    var uans = $(this).attr("value");
    if(uans == ans){

      $("#judge").text("正解！");
      x++;
      y++;
      r++;

      gold = gold + getGold;
      exp = exp + getExp;

      $("#answer").text("");
      $("#result").remove();
      $("#result").val(y);

      if(x == 3){

        $("#next").remove();
        $("#answer").append('<button  id = "result" name = "result" value = "">終了</button>');
      }

    } else {
      $("#judge").text("不正解・・・");
      $("#answer").text("正解は"+ ans + "です。");
      x++;
      r++;

      $("#result").remove();
      $("#result").val(y);

      if(x == 3){

        $("#next").remove();
        $("#answer").append('<button  id = "result" name = "result" value = "">終了</button>');


      }

    }
    if(x == 3){

      z =  r - y;
      hp -= z;
      $("#hit").text(hp);

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
   }else if( r == 1){
      z =  r - y;
      hp -= z;
      $("#hit").text(hp);

      if(hp<1){

        modalopen();

      }else{

        popquestion();

      }

    y = 0;
    r = 0;
  }

  });
  $("#next").on('click',function(){

    //timeAct();
    popquestion();

    timeAct();

  });

});

     var monsId = 3;
     var itemId = 3;

     var timeSet = 90;
     var monsTime = 30;
     var getGold = 500;
     var getExp = 100;
     var goldUp = 1.5;
     var goldUp2 = 2;
     var expUp = 1.5;

     MonsItemJ();

</script>
</head>
<body>

<div id="modal-main">
  <h1>Result</h1>
  <form id = "mainbackform" method = "POST"><button type = "submit" name = "mainback" value = "b">MAPへ戻る</button></form>
</div>
<input type="image" id="modal-open" src="../../../PICTURE/stop.png" name="メニュー" value="メニュー">

<div id="progress"></div>
  <div id="loading"></div>

  <p>HP:<span id= "hit"></span></p>
  <p>問題数:<span id= "no"></span></p>
  <!-- 問題文表示 !-->
  <h2></h2>

   <input type = "button" id = "choices1" class="choice" name="choices1" value="">
   <input type = "button" id = "choices2" class="choice" name="choices2" value="">
   <br>
   <input type = "button" id = "choices3" class="choice" name="choices3" value="">
   <input type = "button" id = "choices4" class="choice" name="choices4" value="">
   <input type = "hidden" name = "answer" value = "">
 <div id="quiz-modal">
   <span id = "judge"></span>
   <span id = "answer"></span>
 <input id = "next" type = "button" name = "next" value = "次へ">
 </div>
</body>
</html>

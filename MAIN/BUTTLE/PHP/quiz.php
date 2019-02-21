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
/*if(isset($_POST["yesClick"])) {
  header("Location: retire.php");
  exit();
}*/

$mons = $_SESSION["currentmonster"];
$mons_json = json_encode((int)$mons, JSON_UNESCAPED_UNICODE);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- Bootstrap core CSS-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link href="../CSS/quiz.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<!--<script src="../JS/prog.js"></script>-->
<script src="../JS/tec_quiz.js"></script>


<script type="text/javascript">


$(function() {
$.fn.timer = function(totalTime) {
// 既に起動済のものがある場合は削除しておく
clearTimeout(this.data('id_of_settimeout'));
this.empty();

// ターゲット内に要素を作成
this.append('<h4><span></span> seconds left.</h4>');
this.append('<div class="progress"></div>');
this.children('.progress').append('<div class="progress-bar progress-bar-info"></div>');
this.find('.progress-bar').css({
cssText: '-webkit-transition: none !important; transition: none !important;',
width: '100%'
});

var countdown = (function(timeLeft) {
var $progressBar = this.find('div.progress-bar');
var $header = this.children('h4');

if (timeLeft == 0) {
$header.empty().text('Over the time limit!').addClass('text-danger');
clearTimeout(this.data('id_of_settimeout'));
this.empty();
$("#judge").text("不正解・・・");
$("#answer").text("正解は"+ ans + "です。");
x++;
r++;
$("#result").val(y);

//body内の最後に<div id="modal-bg"></div>を挿入
$("body").append('<div id="quiz-modalbg"></div>');

//画面中央を計算する関数を実行
modalResize();

//モーダルウィンドウを表示
$("#quiz-modalbg,#quiz-modal").fadeIn("slow");
//画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます

//ボタンをクリックしたらモーダルを閉じる
 $("#next,#result").click(function(){

       $("#quiz-modal,#quiz-modalbg").fadeOut("slow",function(){
    //挿入した<div id="modal-bg"></div>を削除
       $('#quiz-modalbg').remove();
});
});

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

             z =  r - y;
             hp -= z;
             $("#hit").text(hp);
             if(hp<1){

               modalopen();

             }else{

               popquestion();

             }
             return;

}
$header.children('span').text(timeLeft);

var width = (timeLeft - 1) * (100/totalTime); // unit in '%'
if (width < 20) { // less than 20 %
$progressBar.removeClass();
$progressBar.addClass('progress-bar progress-bar-danger');
} else if (width < 50) { // less than 50 % (and more than 20 %)
$progressBar.removeClass();
$progressBar.addClass('progress-bar progress-bar-warning');
}

$progressBar.animate({
width:  width + '%'
}, 1000, 'linear');

var id = setTimeout((function() {
countdown(timeLeft - 1);
}), 1000);
this.data("id_of_settimeout", id);
}).bind(this);

countdown(totalTime);
};
});
jQuery(function($) {
$('#hoge').timer(timeSet);
});
</script>

<title>戦闘</title>
<link rel="stylesheet" href="../CSS/buttle.css">

<script src="../JS/menu.js"></script>
<script type="text/javascript">

//phpから問題を受け取る
let array_key_jq = <?php echo $array_key_json; ?>;
let question_jq = <?php echo $question_json; ?>;
let mons_jq =  <?php echo $mons_json; ?>;

//問題数
var x = 0;
//正答数
var y = 0;
//最大問題数
var r = 0;
//HP
var hp = 2;

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
  function modalopen(){
clearTimeout($("#hoge").data('id_of_settimeout'));
$("#hoge").empty();
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


  }
  $("#hit").text(hp);
  $("#no").text(x);
  $("#t").text(ans);
  $("h2").text(title);
  $("#choices1").val(choices[0]);
  $("#choices2").val(choices[1]);
  $("#choices3").val(choices[2]);
  $("#choices4").val(choices[3]);

  $(".choice").on('click',function() {
clearTimeout($("#hoge").data('id_of_settimeout'));
    $("#hoge").empty();

    //$( "#progress" ).progressbar( "destroy" );

    var uans = $(this).attr("value");
    console.log(uans);
    if(uans == ans){

      $("#judge").text("正解！");
      x++;
      y++;
      r++;

      gold = gold + getGold;

      console.log(gold);

      $("#answer").text("");



      if(x == 10){

        $("#next").remove();
        $("#answer").append('<button  id = "result" name = "result" value = "">終了</button>');
        $("#result").val(y);

        $('#result').click(function(){
          $("#quiz-modal,#quiz-modalbg").fadeOut("slow",function(){
          //挿入した<div id="modal-bg"></div>を削除
              $('#quiz-modalbg').remove();

        });
          });
      }

    } else {
      $("#judge").text("不正解・・・");
      $("#answer").text("正解は"+ ans + "です。");
      x++;
      r++;


      $("#result").val(y);

      if(x == 10){

        $("#next").remove();
        $("#answer").append('<button  id = "result" name = "result" value = "">終了</button>');
        $("#result").val(y);

        $('#result').click(function(){
          $("#quiz-modal,#quiz-modalbg").fadeOut("slow",function(){
          //挿入した<div id="modal-bg"></div>を削除
              $('#quiz-modalbg').remove();

        });
          });
      }

    }
    if(x == 10){

      z =  r - y;
      //$("#hit").text(hp);

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
   }else if(r == 1){
      z =  r - y;
      hp -= z;
      $("#hit").text(hp);
      if(hp<1){

        modalopen();

      }


    y = 0;
    r = 0;
  }

  });
  $("#next").on('click',function(){
    $("#no").text(x);
      popquestion();
    $('#hoge').timer(timeSet);





  });
});

     var itemId = 0;

     var timeSet = 90;
     var monsTime = 30;
     var getGold = 500;
     var goldUp = 1.5;
     var goldUp2 = 2;


     switch(mons_jq){
       case 1:
        switch (itemId) {
          case 0:
          console.log('mons1＆item0');
          timeSet = timeSet + monsTime;
          break;

          case 1:
          console.log('mons1＆item1');
          timeSet = timeSet + monsTime + 15;
          break;

          case 2:
          console.log('mons1＆item2');
          getGold = getGold * 1.25;
          timeSet = timeSet + monsTime　- 15;
          break;

          case 3:
          console.log('mons1＆item3');
          getGold = getGold * 1.5;
          timeSet = timeSet + monsTime - 30;
          break;

        }break;

      case 2:
       switch (itemId) {
         case 0:
         console.log('mons2＆item0');
         getGold = getGold * goldUp;
         timeSet = timeSet - 15;
         break;

         case 1:
         console.log('mons2＆item1');
         getGold = getGold * goldUp;
         break;

         case 2:
         console.log('mons2＆item2');
         getGold = getGold * (goldUp + 1.25 );
         timeSet = timeSet - 30;
         break;

         case 3:
         console.log('mons2＆item3');
         getGold = getGold * (goldUp + 1.5);
         getExp = getExp *expUp;
         timeSet = timeSet - 45;
         break;

       }break;

       case 3:
        switch (itemId) {
          case 0:
          console.log('mons3＆item0');
          getGold = getGold * goldUp2;
          timeSet = timeSet - 30;
          break;

          case 1:
          console.log('mons3＆item1');
          getGold = getGold * goldUp2;
          timeSet = timeSet - 30 + 15;
          break;

          case 2:
          console.log('mons3＆item2');
          getGold = getGold * (goldUp2 + 1.25);
          timeSet = timeSet - 45;
          break;

          case 3:
          console.log('getGold');
          getGold = getGold * (goldUp2 + 1.5);
          timeSet = timeSet - 60;
          break;

        }break;

     }

</script>
</head>
<body>

<div id="modal-main">
  <h1>Result</h1>
  <form action="retire.php" method="POST"><input id="mapback" name="yesClick"type="image" src="../../../PICTURE/MapBack.png"value=""></form>
</div>
<input type="image" id="modal-open" src="../../../PICTURE/stop.png" name="メニュー" value="メニュー">
<div id="hoge">

</div>


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

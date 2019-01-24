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

  if(isset($_POST["result"])){
    $_SESSION["ANS"] = $_POST["result"];
    header("Location: ans.php");
    exit();
  }
 } catch (Exception $e) {
    $errorMessage = $e->getMessage();
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="quiz.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="Tec_quiz.js"></script>
<title>ieeeee</title>
</head>
<body>
<script>
  //phpから問題を受け取る
  let array_key_jq = <?php echo $array_key_json; ?>;
  let question_jq = <?php echo $question_json; ?>;

  //問題数
  let x = 0;
  //正答数
  var y = 0;
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

    $("h2").text(title);
    $("#choices1").val(choices[0]);
    $("#choices2").val(choices[1]);
    $("#choices3").val(choices[2]);
    $("#choices4").val(choices[3]);


    $(".choice").on('click',function() {

      let uans = $(this).attr("value");
      if(uans == ans){
        $("#answer").text("");

        $("#judge").text("正解！");
        x++;
        y++;
      } else {
        $("#judge").text("不正解・・・");
        $("#answer").text("正解は"+ ans + "です。");
        x++;
      }
      if(x == 3){
        $("#next").remove();
        $("#answer").append('<form id = "resultform" method = "POST"><button type = "submit" id = "result" name = "result" value = "">終了</button></form>');
        $("#result").val(y);


      }

    });
    $("#next").on('click',function(){

      //問題表示
      let title = question_jq[array_key_jq[x]].Tec_QuestionText;
      let choices = [question_jq[array_key_jq[x]].Tec_Choices1, question_jq[array_key_jq[x]].Tec_Choices2, question_jq[array_key_jq[x]].Tec_Choices3, question_jq[array_key_jq[x]].Tec_Choices4];
      ans = choices[0];
        //選択肢シャッフル
      for (let i = choices.length - 1; i >= 0; i--){

        // 0~iのランダムな数値を取得
        var rand = Math.floor( Math.random() * ( i + 1 ) );

        // 配列の数値を入れ替える
        [choices[i], choices[rand]] = [choices[rand], choices[i]]

      }

      $("h2").text(title);
      $("#choices1").val(choices[0]);
      $("#choices2").val(choices[1]);
      $("#choices3").val(choices[2]);
      $("#choices4").val(choices[3]);

    });

  });
</script>
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

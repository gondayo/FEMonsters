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

  $i = $_SESSION["qid"];
  function judge($choice, $answer){
            if($choice == $answer){
            	//戦闘処理
              $a = "正解！";
              $_SESSION["ANS"]++;

            }else{
            	//戦闘処理
              $a = "不正解・・・";
            }
  }

    $_SESSION["ANS"] = 0;
      $title = $question[$array_key[$i]]['Tec_QuestionText'];

      $choices = array(); //この変数は配列ですよという宣言
      $choices = array($question[$array_key[$i]]['Tec_Choices1'],$question[$array_key[$i]]['Tec_Choices2'],$question[$array_key[$i]]['Tec_Choices3'],$question[$array_key[$i]]['Tec_Choices4']); //4択の選択肢を設定
    $_SESSION["qid"]++;
      $answer = $choices[0]; //正解の問題を設定

      shuffle($choices); //配列の中身をシャッフル
      if(isset($_POST["choices"])){
        $choice = $_POST["choices"];
        $answer = $_POST["answer"];
      }
      if(isset($_POST["next"])){

        if($i <= 3){
          header("Location: ans.php");
        }
      }



  //}
 } catch (Exception $e) {
    $errorMessage = $e->getMessage();
 }

?>

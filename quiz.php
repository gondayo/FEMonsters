<?php

session_start();
//DBの設定した内容
define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');

// エラーメッセージの初期化
$errorMessage = "";

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

try {
  $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
  $i = 0 ;
  $y = 10 ;


  $sql = "SELECT _QuestionNo, _QuestionText, _Choices1, _Choices2, _Choices3, _Choices4 FROM _dungeon  WHERE _Id = ";
  $question = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);
  $array_key = array_key($question);
  shuffle($array_key);


  while(true){
    if($y < 50){
      $y += 10 ;
    }else{
      $y += 30 ;
    }

    while(true){
      $title = $question[$array_key[$i]]['_QuestionText'];
      $i++;

      $choices   = array(); //この変数は配列ですよという宣言
      $choices = array($Question[$array_key[$i]['_Choices1'],$Question[$array_key[$i]$Question['_Choices2'],$Question[$array_key[$i]$Question['_Choices3'],$Question[$array_key[$i]$Question['_Choices4']); //4択の選択肢を設定

      $answer = $choices[0]; //正解の問題を設定

      shuffle($choices); //配列の中身をシャッフル
    }
  }
 } catch (Exception $e) {
    $errorMessage = $e->getMessage();
 }

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ieeeee</title>
</head>
<body>

<h2><?php echo h($title); ?></h2>
<form method="POST" action="answer.php">
   <?php foreach($choices as $value){ ?>
   <button type="input" name="choices" value="<?php echo h($value); ?>" /> <?php echo h($value); ?><br>
   <?php } ?>
   <input type="hidden" name="answer" value="<?php echo h($answer); ?>">
   <button type="submit" value="回答する">回答する</button>
</form>

</body>
</html>

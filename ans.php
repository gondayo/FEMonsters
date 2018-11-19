<?php
session_start();
//answer.php

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//$question = $_POST['question']; //ラジオボタンの内容を受け取る
//$answer = $_POST['answer'];   //hiddenで送られた正解を受け取る




//結果の判定

  $result = $_SESSION["ANS"];


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>簡易クイズプログラム - 結果</title>
</head>
<body>
  <script>
  console.log(<?php echo $result;?>);
  </script>
<h2>クイズの結果</h2>
<p>あなたの正解数は<?php echo h($result);?>です</p>
<form action="Tec_quiz2.php">

    <input type="submit" value="戻る">
</form>

</body>
</html>

<?php
//セッション開始
session_start();

//DBの設定した内容
//$db['host'] = "mysql1.php.xdomain.ne.jp";  // DBサーバのURL
//$db['user'] = "femonsters09_mi@sv3.php.xdomain.ne.jp";  // ユーザー名
//$db['pass'] = "g015c1154";  // ユーザー名のパスワード
//$db['dbname'] = "femonsters09_db";  // データベース名

//$db['host'] = "localhost";  // DBサーバのURL
//$db['user'] = "zerouser";  // ユーザー名
//$db['pass'] = "0Louser6ga";  // ユーザー名のパスワード
//$db['dbname'] = "test";  // データベース名

define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');

// エラーメッセージの初期化
$errorMessage = "";

// 送信ボタンが押された場合
if (isset($_POST["submit"])){
   //1.ユーザIDの入力チェック
  if(empty($_POST["UserName"])){
    $errorMessage = 'ユーザー名が未入力です。';
  } else if(empty($_POST["SecretQuestion"])){
    $errorMessage = '秘密の質問が未選択です。';

  } else if(empty($_POST["QuestionAnser"])){
    $errorMessage = '質問の答えが未入力です。';
  }

  if (!empty($_POST["UserName"]) && !empty($_POST["SecretQuestion"]) && !empty($_POST["QuestionAnser"])){
    //1.入力したユーザIDと質問の答えを格納
    $UserName = $_POST["UserName"];

    //2.ユーザIDと質問の答えが入力されていたら認証する
    //$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db{'dbname'});


    //3.エラー処理
    try{
      $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));

      $stmt = $pdo->prepare('SELECT UserName FROM user WHERE UserName = ?');
      $stmt->bindvalue(1,$UserName);
      $stmt->execute();

      $SecretQuestion = $POST["SecretQuestion"];
      $QuestionAnser = $POST["QuestionAnser"];

      if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        if($UserId === $row['UserId'] && $SecretQuestion === $row['SecretQuestion'] && $QuestionAnser === $row['QuestionAnser']){
          session_regenerate_id(true);

          // 入力したIDのユーザー名を取得
          //$UserName = $row['UserName'];
					//$sql = "SELECT * FROM user WHERE UserName = $UserName";  //入力したIDからユーザー名を取得
					//$stmt = $pdo->query($sql);
					//foreach ($stmt as $row) {
						//$row['UserName'];  // ユーザー名
					//}
					$_SESSION["NAME"] = $row['UserName'];

          header("Location: PassReword.php"); //再発行画面へ遷移
          exit();

        } else {
          // 認証失敗
          $errorMessage = 'ユーザー名あるいは秘密の質問に誤りがあります。';
        }
      } else {
          // 4. 認証成功なら、セッションIDを新規に発行する
  				// 該当データなし
  				$errorMessage = 'ユーザー名あるいは秘密の質問に誤りがあります。';
        }
      } catch (PDOException $e) {
  			//$errorMessage = 'データベースエラー';
  			$errorMessage = $sql;
  			// $e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
  			// echo $e->getMessage();
    }
  }
}

 ?>

 <!doctype html>
<html>
 <head>
   <meta charset="UTF-8">
   <title>パスワードを忘れた場合</title>
 </head>
 <body>
  <h1>パスワードを忘れた場合</h1>
  <br>
  <form id="ForgotForm" name="ForgotForm" action="" method="POST">
    <fieldset>
      <legend>パスワード変更</legend>
      <label for="UserId">ユーザーIDを入力してください　</label>
      <input type="text" id="UserName" name="UserName" placeholder="ユーザー名を入力" value="">
      <br>
      <br>
      <label for="SecretQuestion">秘密の質問を選択してください　</label>
      <select name="SecretQuestion" required>
        <option value="">選択してください</option>
        <option value="pet">初めて飼ったペットの名前</option>
        <option value="drink">好きな飲み物</optino>
        <option value="sports">好きなスポーツ</option>
        <option value="subject">得意な科目</option>
      </select>
      <br>
      <br>
      <label for="QuestionAnser">質問の答えを入力してください　</label>
      <input type="text" id="QuestionAnser" name="QuestionAnser" placeholder="質問の答えを入力" value="">
      <br>
      <br>
      <input type="submit" id="send" name="send" value="送信">
      <br>
    </fieldset>
  </form>
  <br>
  <form action="Login.php">
    <input type="submit" value="戻る">
  </form>
  </body>
</html>

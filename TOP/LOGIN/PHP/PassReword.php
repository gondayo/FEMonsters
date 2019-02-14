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

//送信ボタンが押された場合
if (isset($_POST["send"])){
  //1.パスワードの入力チェック
  if(empty($_POST["PassWord"])){
   $errorMessage = 'パスワードが未入力です';
 } else if(empty($_POST["PassWord2"])) {
  $errorMessage = 'パスワードが未入力です。';
  }

  if (!empty($_POST["PassWord"]) && !empty($_POST["PassWord2"]) && $_POST["PassWord"] === $_POST["PassWord2"]) {
    // 入力したパスワードを格納
    $PassWord = $_POST["PassWord"];

    //2. パスワードが入力されていたら認証する
    //$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8',$db['host'], $db['dbname']);

    function check($Pass){
      if(($Pass < 8) or ($Pass > 16)){
        throw new Exception('パスワードは8桁以上16桁以内で入力してください。');
      }
    }

    //3.エラー処理
    try {
      $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
      $Pass = strlen($_POST['PassWord']);
      check($Pass);
      $stmt = $pdo->prepare('UPDATE user SET PassWord = ? WHERE UserName = ?');
      $PassWord = password_hash($PassWord, PASSWORD_DEFAULT);
      $stmt->bindvalue(1,$PassWord);
      $stmt->bindvalue(2,$_SESSION["Name"]);
      $stmt->execute();

      header("Location: Return.php");
      exit();

    } catch (Exception $e) {
      $errorMessage = $e->getMessage();
    }
  } else if($_POST["PassWord"] != $_POST["PassWord2"]) {
    $errorMessage = 'パスワードに誤りがあります。';
  }
}

?>

<!doctype html>
<html>
  <head>
    <link href="../CSS/PassReword.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>パスワード再発行</title>
  </head>
  <body>
    <h1>パスワード再発行画面</h1>
    <form id="RewordForm" name="RewordForm" action="" method="POST">
      <fieldset>
        <legend>パスワード再発行</legend>
        <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
        <label for="PassWord">新しいパスワードを入力してください</label>
        <input type="PassWord" id="PassWord" name="PassWord" placeholder="パスワードを入力" value="">
        <br>
        <label for="PassWord2">パスワードを再度入力してください</label>
        <input type="PassWord" id="PassWord2" name="PassWord2" placeholder="パスワードを入力" value="">
        <br>
        <input type="submit" id="send" name="send" value="送信">
      </fieldset>
    </form>
    <br>
    <form action="Login.php">
      <input type="submit" value="戻る">
    </form>
  </body>
</html>

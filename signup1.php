<?php
require 'Password.php'; //バージョンが古かった時の為用対応
//セッション開始
session_start();

//DB
//$db['host'] = "sv3.php.xdomain.ne.jp";
//$db['user'] = "femonsters09_yk";
//$db['pass'] = "g015c1316";
//$db['dbname'] = "femonsters09_db";

define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');



//エラー
$errorMeassage = "";
$sigeUpMessage = "";

// 新規登録ボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["UserName"])) {  // 値が空のとき
        $errorMessage = 'ユーザー名が未入力です。';
    } else if (empty($_POST["PassWord"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["PassWord2"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["UserName"]) && !empty($_POST["PassWord"]) && !empty($_POST["PassWord2"]) && $_POST["PassWord"] === $_POST["PassWord2"]) {
        // 入力したユーザIDとパスワードを格納
        $username = $_POST["UserName"];
        $password = $_POST["PassWord"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        //$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare("INSERT INTO user(name, password,SecretQuestion,QuestionAnser ) VALUES (?, ?, ?, ?)");

            $stmt->execute(array($userName, password_hash($password, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
            $userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

            //$signUpMessage = '登録が完了しました。あなたの登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード

        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
             //$e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
             echo $e->getMessage();
        }
    } else if($_POST["PassWord"] != $_POST["PassWord2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }
}

 ?>


 <!DOCTYPE html>
 <html lang = "ja">
 <head>
   <meta charset = "utf-8">
   <title> 新規登録 </title>
   <link href="main.css" rel = "stylesheet">
 </head>
 <body>
   <h1>新規登録画面</h1>
   <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>新規登録フォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                <label for="UserName">ユーザー名</label><input type="text" id="UserName" name="UserName" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["UserName"])) {echo htmlspecialchars($_POST["UserName"], ENT_QUOTES);} ?>">
                <br>
                <label for="PassWord">パスワード</label><input type="PassWord" id="PassWord" name="PassWord" value="" placeholder="パスワードを入力">
                <br>
                <label for="PassWord2">パスワード(確認用)</label><input type="PassWord" id="PassWord2" name="PassWord2" value="" placeholder="再度パスワードを入力">
                <br>
                <br>

                <label for="SecretQuestion">秘密の質問を選択してください</label>
                <select name="SecretQuestion" required>
                  <option value="">選択してください</option>
                  <option value="pet">初めて飼ったペットの名前</option>
                  <option value="drink">好きな飲み物</optino>
                  <option value="sports">好きなスポーツ</option>
                  <option value="subject">得意な科目</option>
                </select>
                <br>
                <label for="QuestionAnser">質問の答えを入力してください　</label>
                <input type="text" id="QuestionAnser" name="QuestionAnser" placeholder="質問の答えを入力" value="">
                <br>
                <input type="submit" id="signUp" name="signUp" value="新規登録">
            </fieldset>
        </form>
        <br>
        <form action="Login.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>

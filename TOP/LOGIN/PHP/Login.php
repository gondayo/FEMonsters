<?php
require 'Password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();

//DBの設定した内容
//$db['host'] = "mysql1.php.xdomain.ne.jp";  // DBサーバのURL
//$db['user'] = "femonsters09_mi";  // ユーザー名
//$db['pass'] = "g015c1154";  // ユーザー名のパスワード
//$db['dbname'] = "femonsters09_db";  // データベース名

define('DB_DSN','mysql:dbname=femonsters09_db;host=mysql1.php.xdomain.ne.jp;charset=utf8');
define('DB_USER','femonsters09_yk');
define('DB_PASSWORD','g015c1316');



// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
	// 1. ユーザIDの入力チェック
	if (empty($_POST["UserName"])) {  // emptyは値が空のとき
		$errorMessage = 'ユーザー名が未入力です。';
	} else if (empty($_POST["PassWord"])) {
		$errorMessage = 'パスワードが未入力です。';
	}

	if (!empty($_POST["UserName"]) && !empty($_POST["PassWord"])) {
		// 1.入力したユーザ名を格納
		$UserName = $_POST["UserName"];

		// 2. ユーザIDとパスワードが入力されていたら認証する
		//$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

		function check($Pass){
			if(($Pass < 8) and ($Pass > 16)){
				throw new Exception('パスワードは8桁以上16桁以内で入力してください。');
			}
		}

		/*function random($length = 8){
    	return substr(bin2hex(random_bytes($length)), 0, $length);
		}*/

		// 3. エラー処理
		try {
			$pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>FALSE));
			$Pass = strlen($_POST['PassWord']);
			check($Pass);
			$stmt = $pdo->prepare('SELECT UserId,UserName,PassWord FROM user WHERE UserName = ?'); //*ではなく認証に必要な要素のみにする
			$stmt->bindvalue(1,$UserName);
			$stmt->execute();

			$PassWord = $_POST["PassWord"];

			if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

				if (password_verify($PassWord, $row['PassWord'])) {

					session_regenerate_id(true);

					// 入力したユーザー名の確認
					//$UserName = $row['UserName'];
					//$sql = "SELECT UserName FROM user WHERE UserName = $UserName";
					//$stmt = $pdo->query($sql);
					//foreach ($stmt as $row) {
						//$row['UserName'];  // ユーザー名
					//}
					/*$auth = random();
					$stmt = $pdo->prepare('UPDATE user SET Auth = ? WHERE UserName = ?');
					$stmt->bindvalue(1,$auth);
					$stmt->bindvalue(2,$UserName);
					$stmt->execute();*/
					$_SESSION["NAME"] = $row['UserName'];
					//$_SESSION["UID"] = $auth;
					$_SESSION["UID"] = $row['UserId'];
					$st = $pdo->prepare('SELECT MonsterId FROM u_monster WHERE UserId = ? AND MShopFlag = 0');
				  $st->bindvalue(1,(int)$_SESSION["UID"],PDO::PARAM_INT);
				  $st->execute();
				  $umonster = $st->fetch(PDO::FETCH_ASSOC);
					$_SESSION["currentmonster"] = $umonster["MonsterId"];
					header("Location: /MAIN/main.php");  // メイン画面へ遷移
					exit();  // 処理終了
				} else {
					// 認証失敗
					$errorMessage = 'ユーザー名あるいはパスワードに誤りがあります。';
				}
			} else {
				// 4. 認証成功なら、セッションIDを新規に発行する
				// 該当データなし
				$errorMessage = 'ユーザー名あるいはパスワードに誤りがあります。';
			}
		} catch (Exception $e) {
			$errorMessage = $e->getMessage();
			//$errorMessage = $sql;
			 //$e->getMessage() でエラー内容を参照可能（デバック時のみ表示）
			 //echo $e->getMessage();
		}
	}
}
?>

<!doctype html>
<html>
	<head>
		<link href="../CSS/Login.css" rel="stylesheet">
			<meta charset="UTF-8">
			<title>ログイン</title>
	</head>
	<body>
		<h1>ログイン</h1>
		<br>
		<form id="loginForm" name="loginForm" action="" method="POST">
			<fieldset> <!-- fieldsetはグループ化してくれる(線で囲ってくれる) -->
			<div class = "form-item">
				<legend>ログインフォーム</legend>  <!-- グループの先頭には、<LEGEND>〜</LEGEND>で入力項目グループにタイトルをつけます。 -->
				<div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES,'UTF-8'); ?></font></div>
				<label for="UserName">ユーザー名 </label>
				<input type="text" id="UserName" name="UserName" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["UserName"])) {echo htmlspecialchars($_POST["UserName"], ENT_QUOTES,'UTF-8');} ?>">  <!-- 初回起動はユーザーID空白にして、２回目以降はPOST送信したユーザーIDが保存されている。 -->
				<br>
				<br>
				<label for="PassWord">パスワード </label>
				<input type="PassWord" id="PassWord" name="PassWord" value="" placeholder="パスワードを入力"> <!-- プレースホルダーは入力欄に薄く文字を表示させるもの -->
				<br>
				<br>
				<input type="submit" id="login" name="login" value="ログイン">
				<br>

				<br>
				<a href = "Forgot.php">パスワードを忘れた場合</a>
			</fieldset>
		</form>
		<br>
		<form action="/TOP/top.html">
				<input type="submit" id="exit" name="exit" value="戻る">
		</form>
	</body>
</html>

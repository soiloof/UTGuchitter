<?php

/*
・データベースファイル名：users.db
・テーブル名：users
	・id (int(5))、primary key設定(id(隠し番号)の被りを無くすため)、AUTOINCREMENT(id被り防止)
	・name (varchar(20)) unique
	・password (varchar(100))  // ハッシュ化するから少し大きめ
*/

// セッション開始
session_start();

// 変数の設定
$db['dbname'] = "users.db";  // データベースファイル
$username = $_POST["username"];
$password = $_POST["password"];
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {

	// ユーザ名、パスワードの入力チェック
	if (empty($username)) {
		$errorMessage = 'ユーザー名が未入力です。';
	} else if (empty($password)) {
		$errorMessage = 'パスワードが未入力です。';
	} else {

		// ユーザ名、パスワードがあった場合
		try {

			$pdo = new PDO('sqlite:'.$db['dbname']);

			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			// ユーザ名からユーザーデータ 取得
			$stmt = $pdo->prepare('SELECT * FROM users WHERE name = ?');
			$stmt->execute(array($username));

			// ユーザ名がデータベースにあった場合
			if ($row = $stmt->fetch()) {

				// パスワードをハッシュ化して比較
				if (password_verify($password, $row['password'])) {

					session_regenerate_id(true);

					$_SESSION["NAME"] = $username;
					header("Location: UTGuchitter.php");  // メイン画面へ遷移
					exit();  // 処理終了

				} else {

					// 認証失敗
					$errorMessage = 'ユーザー名あるいはパスワードに誤りがあります。';

				}

			} else {

				// 該当データなし
				$errorMessage = 'ユーザー名あるいはパスワードに誤りがあります。';

			}

		} catch (PDOException $e) {
			$errorMessage = $sql;
		}
	}
}

?>




<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>UTGuchitter</title>
  <link rel="stylesheet" type="text/css" href="css/UTGuchitter.css">
</head>
<body>
  <div class="header">
    <div class="header-logo">
      UTGuchitter
    </div>
		<div class="header-current">
      ログイン
    </div>
  </div>
  <nav>
  <ul>
    <li><a href="UTGuchitter_home.php">ホーム</a></li>
    <li><a href="UTGuchitter_information">サービス概要</a></li>
    <li><a href="UTGuchitter_login.php">ログイン</a></li>
    <li><a href="UTGuchitter_contact.php">お問い合わせ</a></li>
  </ul>
</nav>
  <div class="logincontents">
    <h1>ログイン画面</h1>
   <form id="loginForm" name="loginForm" action="" method="POST"></form>

     <fieldset>
       <!-- fieldsetはグループ化してくれる(線で囲ってくれる) -->
       <legend>ログインフォーム</legend>
       <div>
         <font color="#ff0000">
           <?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?>
         </font>
       </div>
       <label for="username">ユーザー名</label>
       <input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($username)) {echo htmlspecialchars($username, ENT_QUOTES);} ?>">
       <!-- 初回起動はユーザーID空白にして、２回目以降はPOST送信したユーザーIDが保存されている。 -->
       <br>
       <label for="password">パスワード</label>
       <input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
       <br>
       <input type="submit" id="login" name="login" value="ログイン">
     </fieldset>
   </form>
   <br>
   <form action="UTGuchitter_signup.php">
     <fieldset>
       <legend>新規登録フォーム</legend>
       <input type="submit" value="新規登録">
     </fieldset>
   </form>
  </div>
</div>
<div class="footer">
  <div class="footer-logo">UTGuchitter</div>
  <div class="footer-list">
    <ul>
      <li>利用規約</li>
      <li>プライバシーポリシー</li>
      <li><a href="UTGuchitter_contact.php">お問い合わせ</a></li>
    </ul>
  </div>
</div>

<footer>
<small>Copyright(C)2018 UTGuchitter,Allright Reserved.</small>
</footer>
</body>
</html>

<?php

session_start();


// 変数の設定
$db['dbname'] = "users.db";  // データベースファイル
$username = $_POST["username"];
$password = $_POST["password"];
$password2 = $_POST["password2"];
$message = "";


// 新規登録ボタンが押された場合
if (isset($_POST["signUp"])) {


	// 1. ユーザ名の入力チェック
	if (empty($username)) {
		$message = 'ユーザー名が未入力です。';
	} else if (empty($password)) {
		$message = 'パスワードが未入力です。';
	} else if (empty($password2)) {
		$message = 'パスワードが未入力です。';
	} else if ($password !== $password2) {
		$message = '入力された2つのパスワードが一致していません。';
	} else {

		try {

			$pdo = new PDO('sqlite:'.$db['dbname']);

			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			$stmt = $pdo->prepare("INSERT INTO users(name, password) VALUES (?, ?)");

			$stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));

			$message = '登録が成功しました';

		} catch (PDOException $e) {
			$message = $e->getMessage();
			if (strpos($message,'name is not unique')){
				$message = '既にそのユーザー名は使われています';
			}
		}
	}
}

?>



<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>新規登録</title>
		<link rel="stylesheet" type="text/css" href="css/UTGuchitter.css">
  </head>
  <body>
		<div class="header">
	    <div class="header-logo">
	      UTGuchitter
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
    <h1>新規登録画面</h1>
    <form id="loginForm" name="loginForm" action="" method="POST">
      <fieldset>
        <legend>新規登録フォーム</legend>
        <div>
          <font color="#ff0000">
                      </font>
        </div>
        <label for="username">ユーザー名</label>
        <input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="">
        <br>
        <label for="password">パスワード</label>
        <input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
        <br>
        <label for="password2">パスワード(確認用)</label>
        <input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
        <br>
        <input type="submit" id="signUp" name="signUp" value="新規登録">
      </fieldset>
    </form>
    <br>
    <form action="UTGuchitter_login.php">
      <input type="submit" value="戻る">
    </form>
		<div class="footer">
		  <div class="footer-logo">UTGuchitter</div>
		  <div class="footer-list">
		    <ul>
		      <li>利用規約</li>
		      <li>プライバシーポリシー</li>
		      <li>お問い合わせ</li>
		    </ul>
		  </div>
		</div>

		<footer>
		<small>Copyright(C)2018 UTGuchitter,Allright Reserved.</small>
		</footer>
  </body>
</html>

<?php

/**
 * ログイン関係の管理用クラス。
 */
class cls_Login
{
	// ブラウザ再起動時のCookieからの再ログイン
	function reLogin()
	{
		// Cookieにログインデータが残っていたら自動再ログインする
		if ($_COOKIE['logUserID'] != '') {
			// そのデータを使ってログイン
			return $this->login($_COOKIE['logUserID'], $_COOKIE['logPassword']);
		}
	}

	// ログイン
	function login($id, $pass)
	{
		echo 'check process<br>';
		if ($id != '' && $pass != '') {
			if ($this->checkID($id) && $this->checkPass($id, $pass)) {
				return true;
			} else {
				return false;
			}
		}
	}

	// ログアウト
	function logout()
	{
		// セッション内容をクリア
		$_SESSION = array();
		session_destroy();

		// Cookieを削除
		// Cookie増やしたらここ追加してあげてください
		setcookie('UserID', '', time() - 420000);

		// トップページに戻る
		header('Location: index.php');
		exit();
	}

	// IDが存在するかのチェック
	function checkID($id)
	{
		echo 'check id...<br>';
		// DB準備
		$dbsrc = 'mysql:host=127.0.0.1; dbname=websysb7; charset=utf8';
		$user = 'root';
		$pass = 'b7';
		try {
			$pdo = new PDO($dbsrc, $user, $pass);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// 問い合わせ
		$st = $pdo->prepare("SELECT UserID FROM User WHERE UserID = :id");
		$st->bindParam(':id', $id, PDO::PARAM_STR);
		$st->execute();

		// 該当するIDがあるかチェック
		while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
			return true;
		}
		return false;
	}

	// パスワードが一致しているかのチェック
	function checkPass($id, $pwd)
	{
		echo 'check pass...<br>';
		// DB準備
		$dbsrc = 'mysql:host=127.0.0.1; dbname=websysb7; charset=utf8';
		$user = 'root';
		$pass = 'b7';
		try {
			$pdo = new PDO($dbsrc, $user, $pass);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// 問い合わせ
		$st = $pdo->prepare("SELECT Password FROM User WHERE UserID = :id");
		$st->bindParam(':id', $id, PDO::PARAM_STR);
		$st->execute();

		// パスワードチェック
		while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
			if ($row['Password'] == $pwd) {
				return true;
			} else {
				return false;
			}
		}

		// パスワードチェック(暗号化できたらこっちに変更するよ)
//		while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
//			// 受け取ったパスワードをBCRYPTのhashに変換
//			$hash = password_hash($pwd,PASSWORD_DEFAULT);
//
//			if(password_verify($row['Password'],$hash)){
//				return true;
//			} else {
//				return false;
//			}
//		}
	}
}

?>
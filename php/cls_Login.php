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
		if (isset($_COOKIE['logUserID'])) {
			// そのデータを使ってログイン
			if ($this->login($_COOKIE['logUserID'], $_COOKIE['logPassword'])) {
				return true;
			} else {
				return false;
			}
		}
	}

	// ログイン
	function login($id, $pass)
	{
		if ($id != '' && $pass != '') {
			if ($this->checkID($id) && $this->checkPass($id, $pass)) {
				return true;
			} else {
				return false;
			}
		}
	}

	// IDが存在するかのチェック
	function checkID($id)
	{
		// DB準備
		require 'db_connect.php';

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
		// DB準備
		require 'db_connect.php';

		// 問い合わせ
		$st = $pdo->prepare("SELECT Password FROM User WHERE UserID = :id");
		$st->bindParam(':id', $id, PDO::PARAM_STR);
		$st->execute();

		// パスワードチェック(暗号化したのでこっちは廃止)
//		while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
//			if ($row['Password'] == $pwd) {
//				return true;
//			} else {
//				return false;
//			}
//		}

		// パスワードチェック(暗号化できたらこっちに変更するよ)
		while ($row = $st->fetch(PDO::FETCH_ASSOC)) {

			if(password_verify($pwd,$row['Password'])){
				return true;
			} else {
				return false;
			}
		}
	}
}

?>
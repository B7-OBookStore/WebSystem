<?php

/**
 * 会員登録時の重複確認用クラス。
 */
class cls_DuplicateCheck
{

	// 電話番号重複チェック
	function existPhone($phone)
	{
		// データベース上に重複したものが存在しているか
		if ($this->dbChecker('Phone', $phone)) {
			return true;
		} else {
			return false;
		}
	}

	// メールアドレス重複チェック
	function existMail($mail)
	{
		if ($this->dbChecker('Mail', $mail)) {
			return true;
		} else {
			return false;
		}
	}

	function existUserID($userid)
	{
		if ($this->dbChecker('UserID', $userid)) {
			return true;
		} else {
			return false;
		}
	}

	// データベースをチェック
	function dbChecker($checkType, $checkStr)
	{
		// Escape
		$checkStr = htmlspecialchars($checkStr, ENT_QUOTES, 'UTF-8');

		// Load DB
		$dbsrc = 'mysql:host=127.0.0.1; dbname=websysb7; charset=utf8';
		$user = 'root';
		$pass = 'b7';
		try {
			$pdo = new PDO($dbsrc, $user, $pass);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		// Prepare Statement
		$stmt = $pdo->prepare('SELECT * FROM User');
		$stmt->execute();

		// Check Duplicate
		foreach ($stmt as $row) {
			if ($row[$checkType] == $checkStr) {
				return true;
			}
		}
		return false;
	}
}

?>
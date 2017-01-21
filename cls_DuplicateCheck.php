<?php

/**
 * 会員登録時の重複確認用クラス。
 */
class cls_DuplicateCheck
{

	// 電話番号重複チェック
	function existPhone($phone)
	{
		if ($this->dbChecker('Phone', $phone)) {
			return '<span style="color:red">この電話番号はすでに登録されています。</span>';
		} else {
			return 'この電話番号は使用できます。';
		}
	}

	// メールアドレス重複チェック
	function existMail($mail)
	{
		if ($this->dbChecker('Mail', $mail)) {
			return '<span style="color:red">このメールアドレスはすでに登録されています。</span>';
		} else {
			return 'このメールアドレスは使用できます。';
		}
	}

	function existUserID($userid)
	{
		if ($this->dbChecker('UserID', $userid)) {
			return '<span style="color:red">このIDはすでに登録されています。</span>';
		} else {
			return 'このIDは使用できます。';
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
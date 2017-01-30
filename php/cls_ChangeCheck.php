<?php

/**
 * 会員登録時の重複確認用クラス。
 */
class cls_ChangeCheck
{

	// 電話番号重複チェック
	function existPhone($phone)
	{
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

	// データベースをチェック
	function dbChecker($checkType, $checkStr)
	{
		session_start();

		// Escape
		$checkStr = htmlspecialchars($checkStr, ENT_QUOTES, 'UTF-8');

		// Load DB
		require 'db_connect.php';

		// Prepare Statement
		$stmt = $pdo->prepare('SELECT * FROM User');
		$stmt->execute();

		$stmt2 = $pdo->prepare("SELECT * FROM User WHERE UserID = :userid");
		$stmt2->bindParam(':userid', $_SESSION['UserID'], PDO::PARAM_STR);
		$stmt2->execute();
		$mydata = $stmt2->fetch(PDO::FETCH_ASSOC);

		// Check Duplicate
		foreach ($stmt as $row) {
			if ($row[$checkType] == $checkStr && $mydata[$checkType] != $checkStr) {
				return true;
			}
		}
		return false;
	}
}

?>
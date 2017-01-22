<?php
/**
 * Userテーブルのテストデータの暗号化されていないものについて
 * パスワードの暗号化処理を行うスクリプト。
 *
 * このphpを起動すると自動で暗号化する。
 * パスワードがすでに暗号化されているかを自動で判断して暗号化を行う。
 */

echo 'パスワードの暗号化を行います...<br>';

require '../php/db_connect.php';

$st = $pdo->prepare("SELECT UserNum, Password FROM User");
$st->execute();

while($row = $st->fetch(PDO::FETCH_ASSOC)){
	echo 'searching'.$row['UserNum'];
	if(!preg_match('/^\$2y\$+/', $row['Password'])) {
		$st2 = $pdo->prepare("UPDATE User SET Password = :password WHERE UserNum = :usernum");
		$usernum = $row['UserNum'];
		$password = password_hash($row['Password'], PASSWORD_DEFAULT);
		$st2->bindParam(':usernum', $usernum, PDO::PARAM_INT);
		$st2->bindParam(':password', $password, PDO::PARAM_STR);
		$st2->execute();

		echo '   ...   UserNum:'.$row['UserNum'].' のパスワードを暗号化しました<br>';
	} else {
		echo '   ...   すでに暗号化されています<br>';
	}
}

echo 'パスワードの暗号化処理が完了しました.';


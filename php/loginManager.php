<?php
/**
 * ログイン処理して返す。
 */
require 'cls_Login.php';

session_start();

$lgn = new cls_Login();

if($lgn->login($_POST['logUserID'], $_POST['logPassword'])){

	// SessionにユーザIDを保存
	$_SESSION['UserID'] = $_POST['logUserID'];

	// Cookieの設定
	setcookie('logUserID', $_POST['logUserID'], time() + 60 * 60 * 24 * 14);
	setcookie('logPassword', $_POST['logPassword'], time() + 60 * 60 * 24 * 14);

	// index.phpに変遷
	header('Location: /index.php');

} else {
	// login.phpに戻る
	header('Location: /login.php?login=failed');
}

exit();
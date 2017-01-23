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
	$cLogUserID = $_POST['logUserID'];
	$cLogPassword = $_POST['logUserID'];

	// Cookieの設定
	setcookie('logUserID', $cLogUserID, time() + 60 * 60 * 24 * 14, '/');
	setcookie('logPassword', $cLogPassword, time() + 60 * 60 * 24 * 14, '/');

	// ログイン前のページに戻る
	if(!empty($_COOKIE['Callback'])) {
		header('Location: '.$_COOKIE['Callback']);
	} else {
		header('Location: /index.php');

	}

} else {
	// login.phpに戻る
	header('Location: /login.php?login=failed');
}
exit();
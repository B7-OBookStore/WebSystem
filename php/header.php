<?php
/**
 * /php/header.php
 * ヘッダ出力用PHP。ログイン状態によってヘッダ表示を変更する。
 */


// セッション開始
session_start();

// ログインページでなかったらCookieにそのページのアドレス保存する
// ->ログイン後にそのページに戻ってこれるようにするため
if(!preg_match('/^\/login\.php.*$/',$_SERVER['REQUEST_URI'])) {
	setcookie('Callback',$_SERVER['REQUEST_URI'],time()+60*60*24*14, '/');
}

$cUserID = $_COOKIE['logUserID'];
$cPassword = $_COOKIE['logPassword'];

// 再接続時にcookieからIDとパスを拾って自動再ログイン
if(!isset($_SESSION['UserID'])){
	require 'cls_Login.php';
	$lgn = new cls_Login();
	if($lgn->reLogin()){
		// Sessionの設定
		$_SESSION['UserID'] = $cUserID;

		// Cookieの設定
		setcookie('logUserID', $cUserID, time() + 60 * 60 * 24 * 14, '/');
		setcookie('logPassword', $cPassword, time() + 60 * 60 * 24 * 14, '/');
	}
}


echo '<header>';

// 非ログイン時の表示
if(!isset($_SESSION['UserID'])) {
	echo '<span>Web注文機能を使うためには、ログインしてください</span>';
	echo '<a id="login" href="../login.php">ログイン</a>';

// ログイン時の表示
} else {
	// ユーザIDから名前を取得
	require 'db_connect.php';
	$headerst = $pdo->prepare("SELECT FirstName, LastName FROM User WHERE UserID = :userid");
	$headerst->bindParam(':userid', $_SESSION['UserID'], PDO::PARAM_STR);
	$headerst->execute();
	while($headerrow = $headerst->fetch(PDO::FETCH_ASSOC)){
		$UserName = $headerrow['LastName'] . $headerrow['FirstName'];
	}

	// 表示部
	echo '<span>ようこそ  '.$UserName.'  さん</span>';
	echo '<a id="login" href="/php/logoutManager.php">ログアウト</a>';
}

echo '</header>';
?>



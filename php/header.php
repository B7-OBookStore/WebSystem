<?php
/**
 * /php/header.php
 * ヘッダ出力用PHP。ログイン状態によってヘッダ表示を変更する。
 */


// セッション開始
session_start();

// ログインページでなかったらCookieにそのページのアドレス保存する
// ->ログイン後にそのページに戻ってこれるようにするため
if (!preg_match('/^\/login\.php.*$/', $_SERVER['REQUEST_URI'])) {
	setcookie('Callback', $_SERVER['REQUEST_URI'], time() + 60 * 60 * 24 * 14, '/');
}

// Cart.phpで「買い物に戻る」を押した時の動作を指定。
// 現在は最後に検索したページに戻るよう動作させる設定です。
if (preg_match('/^\/search\.php.*$/', $_SERVER['REQUEST_URI'])) {
	setcookie('LastSearch', $_SERVER['REQUEST_URI'], time() + 60 * 60 * 24 * 14, '/');
}

$cUserID = $_COOKIE['logUserID'];
$cPassword = $_COOKIE['logPassword'];

// 再接続時にcookieからIDとパスを拾って自動再ログイン
if (!isset($_SESSION['UserID'])) {
	require 'cls_Login.php';
	$lgn = new cls_Login();
	if ($lgn->reLogin()) {
		// Sessionの設定
		$_SESSION['UserID'] = $cUserID;

		// Cookieの設定
		setcookie('logUserID', $cUserID, time() + 60 * 60 * 24 * 14, '/');
		setcookie('logPassword', $cPassword, time() + 60 * 60 * 24 * 14, '/');
	}
}


echo '<header>';

// トップページ以外であれば左にO書店と表示する
if ($_SERVER['REQUEST_URI'] != '/index.php' && $_SERVER['REQUEST_URI'] != '/') {
	echo '<h1><a href="index.php">O書店</a></h1>';
}

// 非ログイン時の表示
if (!isset($_SESSION['UserID'])) {
	echo '<span>Web注文機能を使うためには、ログインしてください</span>';
	echo '<a id="login" href="../login.php">ログイン</a>';

// ログイン時の表示
} else {
	// 各種変数
	$UserName = ''; // ユーザの氏名
	$cartin = false; // カートにアイテムが入っているかどうか

	// ユーザIDから名前を取得
	require 'db_connect.php';
	$headerst = $pdo->prepare("SELECT FirstName, LastName FROM User WHERE UserID = :userid");
	$headerst->bindParam(':userid', $_SESSION['UserID'], PDO::PARAM_STR);
	$headerst->execute();
	while ($headerrow = $headerst->fetch(PDO::FETCH_ASSOC)) {
		$UserName = $headerrow['LastName'] . $headerrow['FirstName'];
	}

	// カートにアイテムがあるかチェック
	$headerst2 = $pdo->prepare("SELECT UserNum,JANCode FROM Cart NATURAL JOIN User WHERE User.UserID = :userid");
	$headerst2->bindParam(':userid', $_SESSION['UserID'], PDO::PARAM_STR);
	$headerst2->execute();
	while ($headerrow2 = $headerst2->fetch(PDO::FETCH_ASSOC)) {
		if (!empty($headerrow2['JANCode'])) {
			$cartin = true;
			break;
		} else {
			$cartin = false;
			break;
		}
	}

	// 表示部
	echo '<span>ようこそ  ' . $UserName . '  さん</span>';
	echo '<a href="user.php"><img src="/img/setting.png"></a>';
	if ($cartin) {
		echo '<a href="cart.php"><img src="/img/cart_exist.png" alt="cart_exist"></a>';
	} else {
		echo '<a href="cart.php"><img src="/img/cart_empty.png" alt="cart_empty"></a>';
	}
	echo '<a id="login" href="/php/logoutManager.php">ログアウト</a>';
}

echo '</header>';
?>



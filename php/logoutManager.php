<?php
/**
 * ログアウト処理。
 */

require 'cls_Login.php';

session_start();

// セッション内容をクリア
$_SESSION = array();
session_destroy();

// Cookieを削除
// Cookie増やしたらここ追加してあげてください
setcookie('logUserID', '', time() - 420000, '/');
setcookie('logPassword', '', time() - 420000, '/');
setcookie('Callback', '', time() - 420000, '/');

// トップページに戻る
header('Location: /index.php');
exit();

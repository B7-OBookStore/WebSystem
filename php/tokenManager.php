<?php
// CSRF対策、POSTがあった場合Tokenをチェック
require 'cls_Token.php';
$csrf = new cls_Token();
if($_SERVER['REQUEST_METHOD'] != 'POST'){
	$csrf->setToken();
} else {
	if(!$csrf->checkToken()) {
		header('Location: index.php?checker=Bad');
		exit;
	}
}
?>
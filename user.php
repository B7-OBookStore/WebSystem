<?php
// セッション
session_start();
// ログインしていなかったら無理矢理index.phpに飛ばす
if (!isset($_SESSION['UserID'])) {
	header('Location: index.php');
	exit();
} else {
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="widh3=device-widh3,initial-scale=1">
	<link rel="stylesheet" href="css/registration.css">
	<link rel="icon" href="img/favicon.ico">
	<script src="js/jquery-3.1.1.min.js"></script>
	<title>O書店</title>
</head>

<body>

<?php require 'php/header.php' ?>

<form id="search" method="get" action="search.php">
	<input name="q" type="search" placeholder="書籍を検索">
	<input type="submit" value="">
</form>

<div id="main">
	<section>
		<h2>会員情報</h2>
		<p><a href="history.php">注文履歴</a></p>
		<p><a href="information.php">会員情報の閲覧</a></p>
		<p><a href="userdata.php">会員情報の修正</a></p>
		<p><a href="userpolicy.html">利用規約</a></p>
	</section>

</div>

<footer>
	<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
</footer>

</body>

</html>
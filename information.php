<?php
// セッション
session_start();

// ログインしていなかったら無理矢理index.phpに飛ばす
if (!isset($_SESSION['UserID'])) {
	header('Location: index.php');
	exit();
}

// データベース準備
require 'php/db_connect.php';

$st = $pdo->prepare("SELECT FirstName, LastName, YomiFirst, YomiLast, Phone, Mail, ZipCode, Pref, City, Address, Apartment
          FROM User WHERE UserID = :userid");
$st->bindParam(':userid', $_SESSION['UserID'], PDO::PARAM_STR);
$st->execute();
$row = $st->fetch(PDO::FETCH_ASSOC);

$replaced = '';

// 郵便番号前半を抽出する正規表現
preg_match('/^.{3}/', $row['ZipCode'], $replaced);
$resultZipCode1 = $replaced[0];

// 郵便番号後半を抽出する正規表現
preg_match('/.{4}$/', $row['ZipCode'], $replaced);
$resultZipCode2 = $replaced[0];

?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="css/information.css">
		<link rel="icon" href="img/favicon.ico">
		<title>O書店</title>
	</head>

	<body>

	<?php
	// ヘッダ表示部分
	require 'php/header.php';
	?>

		<form id="search" method="get" action="search.php">
			<input name="q" type="search" placeholder="書籍を検索">
			<input type="submit" value="">
		</form>

		<div id="main">
			<section>
				<h2>会員情報</h2>
				<table class="type01">
					<tr>
						<th scope="row">名前</th>
						<td><?php echo $row['LastName'].' '.$row['FirstName']; ?></td>
					</tr>
					<tr>
						<th scope="row">フリガナ</th>
						<td><?php echo $row['YomiLast'].' '.$row['YomiFirst']; ?></td>
					</tr>
					<tr>
						<th scope="row">電話番号</th>
						<td><?php echo $row['Phone']; ?></td>
					</tr>
					<tr>
						<th scope="row">メールアドレス</th>
						<td><?php echo $row['Mail']; ?></td>
					</tr>
					<tr>
						<th scope="row">生年月日</th>
						<td><?php echo $row['Year'].'年'.$row['Month'].'月'.$row['Day'].'日'; ?></td>
					</tr>
					<tr>
						<th scope="row">住所</th>
						<td><?php echo $resultZipCode1.'-'.$resultZipCode2.'<br>'.
								$row['Pref'].$row['City'].$row['Address'].$row['Apartment']; ?></td>
					</tr>
				</table>
			</section>


		</div>

		<footer>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</footer>
	</body>

</html>
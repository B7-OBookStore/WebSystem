<?php

// セッション変数にデータを保存
session_start();

$_SESSION['regFirstName'] = $_POST['FirstName'];
$_SESSION['regLastName'] = $_POST['LastName'];
$_SESSION['regYomiFirst'] = $_POST['YomiFirst'];
$_SESSION['regYomiLast'] = $_POST['YomiLast'];
$_SESSION['regPhone'] = $_POST['Phone'];
$_SESSION['regMail'] = $_POST['MailUser'].'@'.$_POST['MailDomain'];
$_SESSION['regUserID'] = $_POST['UserID'];
$_SESSION['regPassword'] = $_POST['Password'];
$_SESSION['regBirth'] = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
$_SESSION['regGender'] = $_POST['Gender'];
$_SESSION['regZipCode'] = $_POST['ZipCode1'].$_POST['ZipCode2'];
$_SESSION['regPref'] = $_POST['pref'];
$_SESSION['regCity'] = $_POST['city'];
$_SESSION['regAddress'] = $_POST['Address'];
$_SESSION['regApartment'] = $_POST['Apartment'];
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="widh3=device-widh3,initial-scale=1">
	<link rel="stylesheet" href="css/register.css">
	<link rel="icon" href="img/favicon.ico">
	<script src="js/register.js"></script>
	<script src="js/jquery-3.1.1.min.js"></script>
	<title>O書店</title>
</head>

<body>

<header>
	<h1><a href="index.php">O書店</a></h1>
	<span>Web注文機能を使うためには、ログインしてください</span>
	<a id="login" href="">ログイン</a>
</header>

<form id="search" method="get" action="search.php">
	<input name="q" type="search" placeholder="書籍を検索">
	<input type="submit" value="">
</form>

<div id="main">
	<section>
		<h2>会員登録</h2>
		<form action="registered.php" method="post">
			<div id="form" class="vertical">
				<div id="id" class="horizontal">
					<h3>ID</h3>
					<div>
						<p><?php echo $_POST['UserID']; ?></p>

					</div>

				</div>
				<div id="password" class="horizontal">
					<h3>パスワード</h3>
					<div>
						<p><?php
							for($i = 0; $i < strlen($_POST['Password']); $i++){
								echo '*';
							}
							?></p>
						<p>セキュリティのためパスワードは伏字になっています。</p>
					</div>
				</div>

				<div id="sex" class="horizontal">
					<h3>性別</h3>
					<div class="horizontal">
						<p><?php
								if($_POST['Gender'] == 'male'){
									echo '男';
								} else {
									echo '女';
								}
							?></p>
					</div>
				</div>

				<div id="name" class="horizontal">
					<h3>氏名</h3>
					<div>
						<p><?php echo $_POST['LastName'] . '  ' . $_POST['FirstName']; ?></p>
					</div>
				</div>

				<div id="phonetic" class="horizontal">
					<h3>フリガナ</h3>
					<div>
						<p><?php echo $_POST['YomiLast'] . '  ' . $_POST['YomiFirst']; ?></p>
					</div>
				</div>

				<div id="birth" class="horizontal">
					<h3>生年月日</h3>
					<p><?php echo $_POST['year'], '年', $_POST['month'], '月', $_POST['day'], '日'; ?></p>
				</div>

				<div id="phonenumber" class="horizontal">
					<h3>電話番号</h3>
					<p><?php echo $_POST['Phone']; ?></p>
				</div>

				<div id="mailaddress" class="horizontal">
					<h3>メールアドレス</h3>
					<p><?php echo $_POST['MailUser'], '@', $_POST['MailDomain']; ?></p>
				</div>

				<div id="address" class="horizontal">
					<h3>住所</h3>

					<div>
						<div>
							<h4>郵便番号</h4>
							<p><?php echo $_POST['ZipCode1'], '-', $_POST['ZipCode2']; ?></p>
						</div>

						<div>
							<h4>都道府県</h4>
							<p><?php echo $_POST['pref']; ?>
						</div>

						<div>
							<h4>市区町村</h4>
							<p><?php echo $_POST['city']; ?></p>
						</div>

						<div>
							<h4>番地</h4>
							<p><?php echo $_POST['Address']; ?></p>
						</div>
						<div>
							<p><?php echo $_POST['Apartment']; ?></p>
						</div>
					</div>
				</div>

				<input class="button_c" type="submit" value="送信">
			</div>
		</form>

		<img id="character" alt="O書店公式キャラクター 羽名しおりちゃん" src="img/register_shiori.png">
	</section>

</div>

<footer>
	<a href="">規約</a>
	<a href="">プライバシー</a>
	<a href="">店舗</a>
</footer>

</body>

</html>
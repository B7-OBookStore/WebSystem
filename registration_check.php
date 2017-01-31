<?php

// セッション変数にデータを保存

require 'php/tokenManager.php';

$_SESSION['regFirstName'] = htmlspecialchars($_POST['FirstName'], ENT_QUOTES, 'UTF-8');
$_SESSION['regLastName'] = htmlspecialchars($_POST['LastName'], ENT_QUOTES, 'UTF-8');
$_SESSION['regYomiFirst'] = htmlspecialchars($_POST['YomiFirst'], ENT_QUOTES, 'UTF-8');
$_SESSION['regYomiLast'] = htmlspecialchars($_POST['YomiLast'], ENT_QUOTES, 'UTF-8');
$_SESSION['regPhone'] = htmlspecialchars($_POST['Phone'], ENT_QUOTES, 'UTF-8');
$_SESSION['regMail'] = htmlspecialchars($_POST['MailUser'].'@'.$_POST['MailDomain'], ENT_QUOTES, 'UTF-8');
$_SESSION['regUserID'] = htmlspecialchars($_POST['UserID'], ENT_QUOTES, 'UTF-8');
$_SESSION['regPassword'] = htmlspecialchars($_POST['Password'], ENT_QUOTES, 'UTF-8');
$_SESSION['regBirth'] = htmlspecialchars($_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'], ENT_QUOTES, 'UTF-8');
$_SESSION['regGender'] = htmlspecialchars($_POST['Gender'], ENT_QUOTES, 'UTF-8');
$_SESSION['regZipCode'] = htmlspecialchars($_POST['ZipCode1'].$_POST['ZipCode2'], ENT_QUOTES, 'UTF-8');
$_SESSION['regPref'] = htmlspecialchars($_POST['pref'], ENT_QUOTES, 'UTF-8');
$_SESSION['regCity'] = htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8');
$_SESSION['regAddress'] = htmlspecialchars($_POST['Address'], ENT_QUOTES, 'UTF-8');
$_SESSION['regApartment'] = htmlspecialchars($_POST['Apartment'], ENT_QUOTES, 'UTF-8');

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="widh3=device-widh3,initial-scale=1">
	<link rel="stylesheet" href="css/registration_check.css">
	<link rel="icon" href="img/favicon.ico">
	<script src="js/register.js"></script>
	<script src="js/jquery-3.1.1.min.js"></script>
	<title>O書店</title>
</head>

<body>

<header>
	<h1><a href="index.php">O書店</a></h1>
</header>

<div id="main">
	<section>
		<h2>以下の情報で登録します。</h2>
		<form action="registered.php" method="post">
			<div id="form" class="vertical">
				<div id="id" class="horizontal">
					<h3>ID</h3>
					<div>
						<p><?php echo htmlspecialchars($_POST['UserID'], ENT_QUOTES, 'UTF-8'); ?></p>

					</div>

				</div>
				<div id="password" class="horizontal">
					<h3>パスワード</h3>
					<div>
						<p><?php
							$pasnum = htmlspecialchars($_POST['Password'], ENT_QUOTES, 'UTF-8');
							for($i = 0; $i < strlen($pasnum); $i++){
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
						<p><?php echo htmlspecialchars($_POST['LastName'] . '  ' . $_POST['FirstName'], ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
				</div>

				<div id="phonetic" class="horizontal">
					<h3>フリガナ</h3>
					<div>
						<p><?php echo htmlspecialchars($_POST['YomiLast'] . '  ' . $_POST['YomiFirst'], ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
				</div>

				<div id="birth" class="horizontal">
					<h3>生年月日</h3>
					<div>
						<p><?php echo htmlspecialchars($_POST['year'].'年'.$_POST['month'].'月'.$_POST['day'].'日', ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
				</div>

				<div id="phonenumber" class="horizontal">
					<h3>電話番号</h3>
					<div>
						<p><?php echo htmlspecialchars($_POST['Phone'], ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
				</div>

				<div id="mailaddress" class="horizontal">
					<h3>メールアドレス</h3>
					<div>
						<p><?php echo htmlspecialchars($_POST['MailUser'].'@'.$_POST['MailDomain'], ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
				</div>

				<div id="address" class="horizontal">
					<h3>住所</h3>

					<div>
						<div>
							<h4>郵便番号</h4>
							<p><?php echo htmlspecialchars($_POST['ZipCode1'].'-'.$_POST['ZipCode2'], ENT_QUOTES, 'UTF-8'); ?></p>
						</div>

						<div>
							<h4>都道府県</h4>
							<p><?php echo htmlspecialchars($_POST['pref'], ENT_QUOTES, 'UTF-8'); ?>
						</div>

						<div>
							<h4>市区町村</h4>
							<p><?php echo htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8'); ?></p>
						</div>

						<div>
							<h4>番地</h4>
							<p><?php echo htmlspecialchars($_POST['Address'], ENT_QUOTES, 'UTF-8'); ?></p>
						</div>
						<div>
							<p><?php echo htmlspecialchars($_POST['Apartment'], ENT_QUOTES, 'UTF-8'); ?></p>
						</div>
					</div>
				</div>
				<input type="hidden" name="Token" value="<?php echo htmlspecialchars($_SESSION['Token'], ENT_QUOTES, 'UTF-8'); ?>">
				<input class="button_c" type="submit" value="送信">
			</div>
		</form>

		<img id="character" alt="O書店公式キャラクター 羽名しおりちゃん" src="img/register_shiori.png">
	</section>

</div>

<footer>
	<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
</footer>

</body>

</html>
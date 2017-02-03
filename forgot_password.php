<?php
	require 'php/db_connect.php';
	require 'php/mailManager.php';

	$mail = htmlspecialchars($_POST['mail_address']);

	$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
	$pwd = '';
	for ($i = 0; $i < 8; ++$i) {
		$pwd .= $chars[mt_rand(0, 35)];
	}

	$stmt = $pdo->prepare("SELECT FirstName,LastName,Mail FROM User WHERE Mail = :mail");
	$stmt->bindParam(':mail',$mail);
	$stmt->execute();

	if ($user = $stmt->fetch()) {
		$send = true;

		$stmt = $pdo->prepare("UPDATE User SET Password=:pwd WHERE Mail = :mail");
		$stmt->bindParam(':pwd',password_hash($pwd, PASSWORD_DEFAULT));
		$stmt->bindParam(':mail',$user[Mail]);
		$stmt->execute();

		$body = "$user[LastName] $user[FirstName] 様\nあなたの新しいパスワードは\n\n"
		.$pwd."\n\nです。ログインできたら、すぐにパスワードの変更を行ってください。\n\n"
		."このメールに心当たりがない場合：\nお手数ですが、support@obookstore.co.jpまでご連絡ください\n\n"
		."-------------------------------------------------\nI県K市 O書店";

		sendMail($user[Mail],'O書店 登録完了のお知らせ',$body);
	}
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="css/forgot_password.css">
		<link rel="icon" href="img/favicon.ico">
		<title>パスワードをリセット - O書店</title>
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
				<h2>パスワードをリセット</h2>
				<form action="forgot_password.php" method="post">
					<p>メールアドレスを入力してください。</p>
					<p><input class="fill inputbox" type="text" name="mail_address"></p>
					<p><input class="button" type="submit" value="送信"></p>
					<input type="hidden" name="Token" value="<?php echo htmlspecialchars($_SESSION['Token'], ENT_QUOTES, 'UTF-8'); ?>">
				</form>
				<?php
					if ($mail != null && $send == true) {
						echo '<small>メールを送信しました。</small>';
					} else if ($mail != null && $send == false) {
						echo '<small>メールアドレスが見つかりません。</small>';
					}
				?>
			</section>
		</div>

		<footer>
			<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
		</footer>

	</body>

</html>
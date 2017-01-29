<?php session_start(); ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="css/login.css">
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
				<h2>ログインページ</h2>
				<form method="POST" action="php/loginManager.php">
					<p>
						<input class="inputbox" type="text" name="logUserID" placeholder="IDまたはメールアドレス">
					</p>
					<p>
						<input class="inputbox" type="password" name="logPassword" placeholder="パスワード">
						<input type="hidden" name="Token" value="<?php echo htmlspecialchars($_SESSION['Token'], ENT_QUOTES, 'UTF-8'); ?>">
					</p>
					<p>
						<input class="button" type="submit" value="送信">
					</p>

					<?php
						if(isset($_GET['login'])){
							echo '<p style="color: red">IDかパスワードが間違っています。</p>';
						}
					?>

					<p>新規登録は<a href="registration.php">こちら</a>。</p>
					<p>パスワードを忘れた方は<a href="forgot_password.php">こちら</a>から。</p>
				</form>
				
				<img id="character" alt="O書店公式キャラクター 陽本綴" src="img/login_himoto.png">

			</section>
		</div>

		<footer>
			<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
		</footer>

	</body>

</html>

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
				<h2>ログインページ</h2>
				<form method="POST" action="php/loginManager.php">
					<p>
						<input class="inputbox" type="text" name="logUserID" placeholder="IDまたはメールアドレス">
					</p>
					<p>
						<input class="inputbox" type="password" name="logPassword" placeholder="パスワード">
					</p>
					<p>
						<input class="button" type="submit" value="送信">
					</p>
				</form>
				<?php
					if(isset($_GET['login'])){
						echo '<p style="color: red">IDかパスワードが間違っています。</p>';
					}
				?>
				<p>パスワードを忘れた方は
					<a href="forgot_password.php">こちら</a>
    から。</p>
			</section>
		</div>

		<footer>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</footer>

	</body>

</html>

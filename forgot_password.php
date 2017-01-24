<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="css/forgot_password.css">
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
				<h2>パスワードをリセット</h2>
				<form>
					<table class="fill">
						<tr>
							<td class="space">メールアドレスを入力してください。</td>
							<td>
								<input class="fill inputbox" type="text" name="mail_address">
							</td>
						</tr>
					</table>
					<p>
						<input class="button" type="submit" value="送信">
					</p>
				</form>
			</section>
		</div>

		<footer>
			<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
		</footer>

	</body>

</html>
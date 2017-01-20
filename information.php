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
				<h2>会員情報</h2>
				<table class="type01">
					<tr>
						<th scope="row">名前</th>
						<td>秦泉寺辰文</td>
					</tr>
					<tr>
						<th scope="row">フリガナ</th>
						<td>ジンゼンジタツフミ</td>
					</tr>
					<tr>
						<th scope="row">電話番号</th>
						<td>000-0000-0000</td>
					</tr>
					<tr>
						<th scope="row">メールアドレス</th>
						<td>abc@inf...</td>
					</tr>
					<tr>
						<th scope="row">生年月日</th>
						<td>〇〇〇〇年〇月〇日</td>
					</tr>
					<tr>
						<th scope="row">住所</th>
						<td>浜松市〇〇</td>
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
<?php
	$dsn = 'mysql:dbname=b7_obookstore;host=ja-cdbr-azure-east-a.cloudapp.net;charset=utf8';
	$username = 'b62d87cb5623a5';
	$password = '6d93d6d8';
	$pdo = new PDO($dsn, $username, $password);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="css/index.css">
	<link rel="icon" href="img/favicon.ico">
	<title>O書店</title>
</head>

<body>
	<header>
			<span>Web注文機能を使うためには、ログインしてください</span>
			<a id="login" href="">ログイン</a>
	</header>

	<div id="main">
		<div>
		<h1>O書店</h1>
		<p>お客様は王様であり、私たちは本の王様である。</p>
		
		<form id="search" method="get" action="search.php">
				<input name="q" type="search" placeholder="書籍を検索"><!--
				--><input  type="submit" value="">
		</form>
		</div>
	</div>
	
	<footer>
		<section id="pickedbooks">
			<?php
				$stmt = $pdo->query("SELECT book.JANCode,GoogleID,ProductName,SUM(Num) AS NumSum FROM book,product,stock WHERE book.JANCode = product.JANCode AND book.JANCode = stock.JANCode AND GoogleID IS NOT NULL GROUP BY book.JANCode ORDER BY NumSum DESC LIMIT 40");

				foreach ($stmt as $row) {
					echo "<a class='book'>";
					echo "<img alt='$row[ProductName]' src='http://books.google.com/books/content?id=$row[GoogleID]&printsec=frontcover&img=1&zoom=5&source=gbs_api'>";
					echo "<p>$row[ProductName]</p>";
					echo "</a>";
				}
			?>
		</section>

		<nav>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</nav>
	</footer>
</body>

</html>
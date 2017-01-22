<?php
	require 'php/db_connect.php';
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

	<?php
		// ヘッダ表示部分
		require 'php/header.php';
	?>


		<div id="main">
			<div>
				<h1>O書店</h1>
				<p>お客様は王様であり、私たちは本の王様である。</p>

				<form id="search" method="get" action="search.php">
					<input name="q" type="search" placeholder="書籍を検索">
					<input type="submit" value="">
				</form>
			</div>
		</div>

		<footer>
			<section id="pickedbooks">
				<?php
					$stmt = $pdo->query("SELECT SUM(StockAmount) AS Amount,BookTitle,GoogleID FROM Stock INNER JOIN Book ON Stock.JANCode = Book.JANCode WHERE GoogleID IS NOT NULL GROUP BY Stock.JANCode ORDER BY AMOUNT DESC LIMIT 40");
					
					foreach ($stmt as $row) {
						echo "<a class='book' href='book.php?id=$row[GoogleID]'>";
						echo "<img alt='$row[BookTitle]' src='http://books.google.com/books/content?id=$row[GoogleID]&printsec=frontcover&img=1&zoom=5&source=gbs_api'>";
						echo "<p>$row[BookTitle]</p>";
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
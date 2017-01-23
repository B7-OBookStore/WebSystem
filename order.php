<?php
	require 'php/db_connect.php';
	require 'php/cls_Book.php';
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="css/order.css">
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
			<section id="store" class="vertical">
				<h2>お受け取りに使う店舗を選択してください</h2>

				<form class="horizontal" action="order_check.php" method="post">
					<div>
						<?php
							$stmt = $pdo->query("SELECT * FROM Store WHERE StoreNum <> 0");

							foreach ($stmt as $row) {
								echo "<input type='radio' name='store' value='$row[StoreNum]'>$row[StoreName]<br>";
							}
						?>
					</div>
					<input class="button" type="submit" value="決定">
				</form>
			</section>

			<section id="cart">
				<h2>注文内容</h2>
					<?php
						$userID = $_SESSION['UserID'];
						$stmt = $pdo->query("SELECT Book.JANCode,Price,BookTitle,Writer,GoogleID FROM Cart INNER JOIN Item ON Cart.JANCode = Item.JANCode INNER JOIN Book ON Cart.JANCode = Book.JANCode INNER JOIN User ON Cart.UserNum = User.UserNum WHERE UserID = '$userID'");

						foreach ($stmt as $row) {
					?>
					<section class="horizontal items">
						<img alt="<?php echo $row[BookTitle] ?>" src="http://books.google.com/books/content?id=<?php echo $row[GoogleID] ?>&printsec=frontcover&img=1&zoom=5&source=gbs_api">

						<div class="info">
							<h3><?php echo $row[BookTitle] ?></h3>

							<p><?php echo $row[Writer] ?></p>
							<p class="price">￥
							<?php
								if ($row[Price] == NULL){
									echo "(注文確定後にお知らせ)";
								} else {
									echo $row[Price];
								}
							?></p>
						</div>

						<a class="button" href="cart_delete.php?id=<?php echo $row[GoogleID] ?>">削除</a>
					</section>
					<?php
						}
					?>
			</section>
		</div>

		<footer>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</footer>

	</body>

</html>
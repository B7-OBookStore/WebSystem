<?php
	require 'php/db_connect.php';
	require 'php/cls_Book.php';
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="css/cart.css">
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
			<div id="cart">

				<section>
					<h2>カートに入っている商品</h2>
					<?php
						$userID = $_SESSION['UserID'];
						$stmt = $pdo->query("SELECT GoogleID FROM Cart INNER JOIN Book ON Cart.JANCode = Book.JANCode INNER JOIN User ON Cart.UserNum = User.UserNum WHERE UserID = '$userID'");

						foreach ($stmt as $row) {
							$item = new Book($row[GoogleID]);
					?>
					<section>
						<img alt="<?php echo $item->title ?>" src="<?php echo $item->imageLinks[thumbnail] ?>">

						<h3><?php echo $item->title ?></h3>

						<p class="publishedDate"><?php echo $item->publishedDate ?></p>
						<p><?php echo $item->writer ?></p>
						<p class="price">￥
						<?php
							if ($item->price == NULL){
								echo "(注文確定後にお知らせ)";
							} else {
								echo $item->price;
							}
						?></p>
					</section>
					<?php
						}
					?>
				</section>
			</div>

			<section id="nav">
				<p><a class="button" href="order.php">注文を確定する</a></p>
				<p><a class="button_c" href="">買い物を続ける</a></p>
			</section>
		</div>

		<footer>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</footer>

	</body>

</html>
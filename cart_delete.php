<?php
	require 'php/db_connect.php';
	require 'php/cls_Book.php';

	$id = $_GET["id"];
	
	if ($id == NULL){
		header( "Location: index.php" ) ;
		exit;
	}
	
	$book = new Book($id);
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
					<h2>カートから削除しました</h2>
					<?php
						/* カートに追加する本をデータベースから検索、無ければ追加 */
						$sql = "DELETE Cart FROM Cart INNER JOIN User ON Cart.UserNum = User.UserNum WHERE JANCode = $book->janCode AND UserID=:userid";
						$stmt = $pdo->prepare($sql);
						$stmt->bindParam(':userid', $_SESSION['UserID']);
						$stmt->execute();
					?>
					<section class="horizontal items">
						
						<img alt="<?php echo $book->title ?>" src="<?php echo $book->imageLinks[thumbnail] ?>">

						<div class="info">
							<h3><?php echo $book->title ?></h3>

							<p class="publishedDate"><?php echo $book->publishedDate ?></p>
							<p><?php echo $book->writer ?></p>
							<p class="price">￥ <?php echo $book->price ?></p>
						</div>

						<a class="button" href="cart_update.php?id=<?php echo $id ?>">元に戻す</a>
					</section>
				</section>

				<section>
					<h2>カートに入っている商品</h2>
					<?php
						$userID = $_SESSION['UserID'];
						$stmt = $pdo->query("SELECT GoogleID FROM Cart INNER JOIN Book ON Cart.JANCode = Book.JANCode INNER JOIN User ON Cart.UserNum = User.UserNum WHERE UserID = '$userID'");

						foreach ($stmt as $row) {
							$item = new Book($row[GoogleID]);
					?>
					<section class="horizontal items">
						<img alt="<?php echo $item->title ?>" src="<?php echo $item->imageLinks[thumbnail] ?>">

						<div class="info">
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
						</div>

						<a class="button" href="cart_delete.php?id=<?php echo $row[GoogleID] ?>">削除</a>
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
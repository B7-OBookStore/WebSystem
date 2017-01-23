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
					<?php
						/* カートに追加する本をデータベースから検索、無ければ追加 */
						$sql = "INSERT INTO Cart SELECT UserNum,$book->janCode FROM User WHERE UserID=:userid";
						$stmt = $pdo->prepare($sql);
						$stmt->bindParam(':userid', $_SESSION['UserID']);
						$result = $stmt->execute();
						
						if ($result) {
							echo '<h2>カートに追加しました</h2>';
						} else {
							echo '<h2>既にカートに追加されています</h2>';
						}
					?>
					<img alt="<?php echo $book->title ?>" src="<?php echo $book->imageLinks[thumbnail] ?>">

					<h3><?php $book->title ?></h3>

					<p class="publishedDate"><?php echo $book->publishedDate ?></p>
					<p><?php echo $book->writer ?></p>
					<p class="price">￥ <?php echo $book->price ?></p>
				</section>

				<section>
					<h2>カートに入っている商品</h2>
					<img alt="<?php echo $title ?>" src="<?php echo $imageLink ?>">

					<h3><?php echo $title ?></h3>

					<p class="publishedDate"><?php echo $publishedDate ?></p>
					<p><?php echo $authors ?></p>
					<p class="price">￥ <?php echo $listPrice ?></p>
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
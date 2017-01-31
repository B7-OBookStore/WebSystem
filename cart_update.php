<?php
	require 'php/db_connect.php';
	require 'php/cls_Book.php';

	session_start();
	if (!isset($_SESSION['UserID'])) {
		header('Location: login.php');
		exit();
	}

	$id = htmlspecialchars($_GET["id"], ENT_QUOTES, 'UTF-8');
	
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
		<title>カート - O書店</title>
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
						$sql = "INSERT INTO Cart SELECT UserNum,:jancode FROM User WHERE UserID=:userid";
						$stmt = $pdo->prepare($sql);
						$stmt->bindParam(':jancode', $book->janCode, PDO::PARAM_STR);
						$stmt->bindParam(':userid', $_SESSION['UserID'], PDO::PARAM_STR);
						$result = $stmt->execute();
						
						if ($result) {
							echo '<h2>カートに追加しました</h2>';
						} else {
							echo '<h2>既にカートに追加されています</h2>';
						}
					?>
					<section class="horizontal item">
						
						<img alt="<?php echo $book->title ?>" src="<?php echo $book->imageLinks[thumbnail] ?>">

						<div class="info">
							<h3><?php echo $book->title ?></h3>

							<p class="publishedDate"><?php echo $book->publishedDate ?></p>
							<p><?php echo $book->writer ?></p>
							<p class="price">￥
							<?php
								if ($book->price == NULL) {
									echo "(注文確定後にお知らせ)";
								} else {
									echo $book->price;
								}
							?>
							</p>
						</div>

						<a class="button" href="cart_delete.php?id=<?php echo $id ?>">削除</a>
					</section>
				</section>

				<section>
					<h2>カートに入っている商品</h2>
					<?php
						$userID = $_SESSION['UserID'];
						$stmt = $pdo->query("SELECT Book.JANCode,Price,BookTitle,Writer,GoogleID FROM Cart INNER JOIN Item ON Cart.JANCode = Item.JANCode INNER JOIN Book ON Cart.JANCode = Book.JANCode INNER JOIN User ON Cart.UserNum = User.UserNum WHERE UserID = '$userID'");
						$count = 0;

						foreach ($stmt as $row) {
					?>
					<section class="item">
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
							$count++;
						}
						if ($count === 0) {
							echo '<p>現在カートに入っている商品はありません。</p>';
						}
					?>
				</section>
			</div>

			<section id="nav">
				<?php if ($count !== 0) {?>
				<p><a class="button" href="order.php">注文を確定する</a></p>
				<?php } ?>
				<p><a class="button_c" href="book.php?id=<?php echo $id ?>">買い物を続ける</a></p>
			</section>
		</div>

		<footer>
			<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
		</footer>

	</body>

</html>
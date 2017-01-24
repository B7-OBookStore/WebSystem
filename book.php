<?php
	// データベースに接続
	require 'php/db_connect.php';
	require 'php/cls_Book.php';

	// GETでGoogleBooksのIDを取得
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
		<link rel="stylesheet" href="css/book.css">
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
			<section id="container">
				<img alt="<?php echo $book->title ?>" src="<?php echo $book->imageLinks['small'] ?>">

				<div>
					<a id="add" class="button" href="cart_update.php?id=<?php echo $id ?>">カートに追加</a>

					<h2><?php echo $book->title ?></h2>

					<p class="publishedDate"><?php echo $book->publishedDate ?></p>
					<p><?php echo $book->writer ?></p>
					<p class="price">￥ <?php
						if ($book->price == NULL){
							echo "(注文確定後にお知らせ)";
						} else {
							echo $book->price;
						}
						?></p>

					<h3>在庫状況</h3>
					<table>
						<tr>
							<?php
								$stmt = $pdo->query("SELECT StoreName FROM Store WHERE StoreNum <> 0");

								foreach ($stmt as $row) {
									echo "<th>$row[StoreName]</th>";
									$storeCount++;
								}
							?>
						</tr>
						<tr>
							<?php
								$stmt = $pdo->query("SELECT Store.StoreNum,StockAmount FROM Store LEFT JOIN Stock ON Store.StoreNum = Stock.StoreNum AND JANCode = $book->janCode WHERE Store.StoreNum <> 0 ORDER BY Store.StoreNum");

								foreach ($stmt as $row) {
									$num = $row[StockAmount];

									echo '<td>';
									if ($num == 0) {
										echo '×';
									} else if ($num < 10) {
										echo '△';
									} else {
										echo '〇';
									}
									echo '</td>';
								}
							?>
						</tr>
					</table>
				</div>
			</section>

			<section id="info">
				<?php
					if ($book->description != NULL){
						echo '<h3>商品説明</h3>';
						echo "<p>$book->description</p>";
					}
				?>

				<?php
					if ($book->categories != NULL){
						echo '<h3>ジャンル</h3>';

						foreach($book->categories as $i => $category) {
							echo "<p>$category</p>";
						}
					}
				?>

				<h3>出版社</h3>
				<p><?php echo $book->publisher ?></p>

				<h3>登録情報</h3>
				<table>
					<tr>
						<th>JANコード</th>
						<td><?php echo $book->janCode ?></td>
					</tr>
					<tr>
						<th>ISBN10</th>
						<td><?php echo $book->isbn10 ?></td>
					</tr>
				</table>
			</section>
		</div>

		<footer>
			<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
		</footer>

	</body>

</html>
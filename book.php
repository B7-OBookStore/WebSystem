<?php
	$dsn = 'mysql:dbname=b7_obookstore;host=ja-cdbr-azure-east-a.cloudapp.net;charset=utf8';
	$username = 'b62d87cb5623a5';
	$password = '6d93d6d8';
	$pdo = new PDO($dsn, $username, $password);
	
	$id = $_GET["id"];
	
	if ($id == NULL){
		header( "Location: index.php" ) ;
		exit;
	}
	
	$json = file_get_contents("https://www.googleapis.com/books/v1/volumes/$id?key=AIzaSyBczORlfI6MEmYnkTFwP5au6rq_oo4h92s");
	$results = json_decode($json, TRUE);
	
	foreach ($results[volumeInfo][industryIdentifiers] as $i => $identifier) {
		if ($identifier[type] === "ISBN_10") {
			$isbn10 = $identifier[identifier];
		}
		if ($identifier[type] === "ISBN_13") {
			$janCode = $identifier[identifier];
		}
	}
	
	$title = $results[volumeInfo][title]." ".$results[volumeInfo][subtitle];
	$publishedDate = $results[volumeInfo][publishedDate];
	$description = $results[volumeInfo][description];
	$publisher = $results[volumeInfo][publisher];
	$categories = $results[volumeInfo][categories];
	
	foreach($results[volumeInfo][authors] as $i => $author) {
		$authors = $authors.$author."　";
	}
	$authors = rtrim($authors,'　');
	
	if ($results[volumeInfo][imageLinks][small] == NULL){
		if ($results[volumeInfo][imageLinks][thumbnail] == NULL){
			$imageLink = "img/noimage.png";
		} else {
			$imageLink = $results[volumeInfo][imageLinks][thumbnail];
		}
	} else {
		$imageLink = $results[volumeInfo][imageLinks][small];
	}
	
	$listPrice = $results[saleInfo][listPrice][amount];
	$stmt = $pdo->query("SELECT Price FROM product WHERE JANCode = $janCode");
	if ($result = $stmt->fetch()) {
		$listPrice = $result[Price];
	}
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

		<header>
			<h1><a href="index.php">O書店</a></h1>
			<span>Web注文機能を使うためには、ログインしてください</span>
			<a id="login" href="">ログイン</a>
		</header>

		<form id="search" method="get" action="search.php">
			<input name="q" type="search" placeholder="書籍を検索">														 <!--
																	 --><input type="submit" value="">
		</form>

		<div id="main">
			<section id="container">
				<img alt="<?php echo $title ?>" src="<?php echo $imageLink ?>">

				<div>
					<a id="add" class="button" href="cart_update.php?id=<?php echo $id ?>">カートに追加</a>

					<h2><?php echo $title ?></h2>

					<p class="publishedDate"><?php echo $publishedDate ?></p>
					<p><?php echo $authors ?></p>
					<p class="price">￥ <?php
						if ($listPrice == NULL){
							echo "(注文確定後にお知らせ)";
						} else {
							echo $listPrice;
						}		   
						?></p>

					<h3>在庫状況</h3>
					<table>
						<tr>
							<?php
								$stmt = $pdo->query("SELECT StoreName FROM store");
								
								foreach ($stmt as $row) {
									echo "<th>$row[StoreName]</th>";
									$storeCount++;
								}
							?>
						</tr>
						<tr>
							<?php
								for ($i = 0; $i < $storeCount; $i++){
									$stmt = $pdo->query("SELECT Num FROM stock WHERE JANCode = $janCode AND StoreNumber = $i");
								
									$stock = $stmt->fetch();
									$num = $stock[Num];
								
									echo '<td>';
									if ($num == 0 || !$stock) {
										echo '×';
									} else if ($num < 5) {
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
					if ($description != NULL){
						echo '<h3>商品説明</h3>';
						echo "<p>$description</p>";
					}
				?>

				<?php
					if ($categories != NULL){
						echo '<h3>ジャンル</h3>';
					
						foreach($categories as $i => $category) {
							echo "<p>$category</p>";
						}
					}
				?>

				<h3>出版社</h3>
				<p><?php echo $publisher ?></p>
			</section>
		</div>

		<footer>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</footer>

	</body>

</html>
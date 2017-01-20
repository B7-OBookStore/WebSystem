<?php
	$id = $_GET["id"];
	
	if ($id == NULL){
		header( "Location: index.php" ) ;
		exit;
	}
	
	/* 本の情報を取得 */
	$json = file_get_contents("https://www.googleapis.com/books/v1/volumes/$id?key=AIzaSyBczORlfI6MEmYnkTFwP5au6rq_oo4h92s");
	$results = json_decode($json, TRUE);
	
	$title = $results[volumeInfo][title]." ".$results[volumeInfo][subtitle];
	$publishedDate = $results[volumeInfo][publishedDate];
	$publisher = $results[volumeInfo][publisher];
	$imageLink = $results[volumeInfo][imageLinks][smallhumbnail];
	
	foreach ($results[volumeInfo][industryIdentifiers] as $i => $identifier) {
		if ($identifier[type] === "ISBN_10") {
			$isbn10 = $identifier[identifier];
		}
		if ($identifier[type] === "ISBN_13") {
			$janCode = $identifier[identifier];
		}
	}
	
	foreach($results[volumeInfo][authors] as $i => $author) {
		$authors = $authors.$author."　";
	}
	$authors = rtrim($authors,'　');
	
	if ($results[saleInfo][listPrice][amount] == NULL) {
		$listPrice = "(注文確定後にお知らせ)";
	} else {
		$listPrice = $results[saleInfo][listPrice][amount];
	}
	
	if ($results[volumeInfo][imageLinks][thumbnail] == NULL){
		$imageLink = "img/noimage.png";
	} else {
		$imageLink = $results[volumeInfo][imageLinks][thumbnail];
	}
	
	/* データベースに接続 */
	$dsn = 'mysql:dbname=b7_obookstore;host=ja-cdbr-azure-east-a.cloudapp.net;charset=utf8';
	$username = 'b62d87cb5623a5';
	$password = '6d93d6d8';
	$pdo = new PDO($dsn, $username, $password);
	
	/* カートに追加する本をデータベースから検索、無ければ追加 */
	$sql = "SELECT count(*) FROM product WHERE JANCode='$janCode'";
	$stmt = $pdo->query($sql);
	$count = $stmt->fetchColumn();
	
	if ($count == 0) {
		$sql = "INSERT INTO product VALUES(:JANCode,:Price,:ProductName)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':JANCode',$janCode);
		if ($results[saleInfo][listPrice][amount] == NULL) {
			$stmt->bindValue(':Price',NULL,PDO::PARAM_NULL);
		} else {
			$stmt->bindParam(':Price',$listPrice);
		}
		$stmt->bindParam(':ProductName',$title);
		$stmt->execute();
	
		$sql = "INSERT INTO book VALUES(:JANCode,:Writer,:Publisher,:ISBN10,:MagazineCode,:GoogleID)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':JANCode',$janCode);
		$stmt->bindParam(':Writer',$authors);
		$stmt->bindParam(':Publisher',$publisher);
		$stmt->bindParam(':ISBN10',$isbn10);
		$stmt->bindValue(':MagazineCode',NULL,PDO::PARAM_NULL);
		$stmt->bindParam(':GoogleID',$id);
		$stmt->execute();
	}
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
			<div id="cart">
				<section>
					<h2>カートに追加しました</h2>
					<!-- <?php echo $count ?> --><?php echo $count ?> -->
					<img alt="<?php echo $title ?>" src="<?php echo $imageLink ?>">

					<h3><?php echo $title ?></h3>

					<p class="publishedDate"><?php echo $publishedDate ?></p>
					<p><?php echo $authors ?></p>
					<p class="price">￥ <?php echo $listPrice ?></p>
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
				<p><a class="button" href="order.php?id=<?php echo $id ?>">注文を確定する</a></p>
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
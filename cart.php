<?php
	$id = $_GET["id"];
	
	if ($id == NULL){
		header( "Location: index.php" ) ;
		exit;
	}
	
	/* 本の情報を取得 */
	$json = file_get_contents("https://www.googleapis.com/books/v1/volumes/".$id);
	$results = json_decode($json, TRUE);
	
	$title = $results[volumeInfo][title]." ".$results[volumeInfo][subtitle];
	$publishedDate = $results[volumeInfo][publishedDate];
	$imageLink = $results[volumeInfo][imageLinks][smallhumbnail];
	
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
					<h2>カートに追加しました</h2>
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
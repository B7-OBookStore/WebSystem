<?php
	$id = $_GET["id"];
	$shop = $_GET["shop"];
	
	if ($id == NULL){
		header( "Location: index.php" ) ;
		exit;
	}
	
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
		<link rel="stylesheet" href="css/order.css">
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
			<section>
				<h2>お受け取りに使う店舗を選択してください</h2>

				<fieldset form="submit">
					<input type="radio" name="shop" value="本店">本店<br>
					<input type="radio" name="shop" value="駅前店">駅前店<br>
					<input type="radio" name="shop" value="工大前店">工大前店<br>
					<input type="radio" name="shop" value="県庁通店">県庁通店<br>
					<input type="radio" name="shop" value="プラザ店">プラザ店<br>
					<input type="radio" name="shop" value="山環状店">山環状店<br>
				</fieldset>

				<a class="button" href="#overray">決定</a>

			</section>

			<section>
				<h2>注文内容</h2>
				<img alt="<?php echo $title ?>" src="<?php echo $imageLink ?>">

				<h3><?php echo $title ?></h3>

				<p class="publishedDate"><?php echo $publishedDate ?></p>
				<p><?php echo $authors ?></p>
				<p class="price">￥ <?php echo $listPrice ?></p>
			</section>
		</div>

		<footer>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</footer>

		<div id="overray"></div>
		<div id="container">
			<div id="dialog">
				<h2>注文最終確認</h2>
				<h3>お受け取りの店舗</h3>
				<p>本店</p>

				<h3>注文内容</h3>
				<p><?php echo $title ?></p>

				<div id="button">
					<form id="submit" method="get" action="order.php">
						<button class="button" type="submit">注文を確定</button>
					</form>
					<a class="button_c" href="#" class="button">閉じる</a>
				</div>
			</div>
		</div>

	</body>

</html>
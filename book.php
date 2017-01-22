<?php
	// データベースに接続
	$dsn = 'mysql:dbname=websysb7;host=ja-cdbr-azure-east-a.cloudapp.net;charset=utf8';
	$username = 'b3a7f491a4430f';
	$password = '0a1e66e0';
	$pdo = new PDO($dsn, $username, $password);
	
	// GoogleBooksAPIから色々取得
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
		$authors = $authors.$author.",";
	}
	$authors = rtrim($authors,',');
	
	if ($results[volumeInfo][imageLinks][small] == NULL){
		if ($results[volumeInfo][imageLinks][thumbnail] == NULL){
			$imageLink = "img/noimage.png";
		} else {
			$imageLink = $results[volumeInfo][imageLinks][thumbnail];
		}
	} else {
		$imageLink = $results[volumeInfo][imageLinks][small];
	}
	
	// DBから価格を取得
	$stmt = $pdo->query("SELECT Price FROM Item WHERE JANCode = $janCode");
	if ($result = $stmt->fetch()) {
		$listPrice = $result[Price];
	}
	// DBになかったらGoogleBooksから取得
	if ($listPrice == NULL){
		$listPrice = $results[saleInfo][listPrice][amount];
	}
	// GoogleBooksにもなかったら国会図書館から取得。かなり無理矢理
	mb_language('Japanese');
	mb_internal_encoding('UTF-8');
	
	if ($listPrice == NULL) {
		$html = file_get_contents("http://iss.ndl.go.jp/books?ar=4e1f&search_mode=advanced&display=&rft.isbn=9784046316417");
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$as = $dom->getElementsByTagName('a');
	
		foreach ($as as $a) {
			$url = $a->getAttribute('href');

			if (preg_match("#^http://iss.ndl.go.jp/books/#",$url)) {
				$html = file_get_contents($url);
				$dom = new DOMDocument();
				@$dom->loadHTML($html);
				$spans = $dom->getElementsByTagName('span');
	
				foreach ($spans as $span){
					$spanValue = $span->nodeValue;
					if (mb_substr($spanValue ,-1) == '円'){
						// 国会図書館のデータは税抜き価格なので1.08かける
						$priceWithoutTax = preg_replace('/[^0-9]/','',$spanValue);
						$listPrice = (int)($priceWithoutTax*1.08);
						break;
					}
				}
				break;
			}
		}
	}
	/*
	// JANKEN.JPから取得するスクリプトだが、国会図書館になけりゃここにもあるわけがないので省略
	if ($listPrice == NULL) {
		$html = file_get_contents("http://www.janken.jp/goods/jk_catalog_syosai.php?jan=$janCode");
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$tds = $dom->getElementsByTagName('td');
	
		foreach ($tds as $td){
			$tdValue = $td->nodeValue;
			if (mb_substr($tdValue ,0 ,1) == '\\'){
				$listPrice = preg_replace('/[^0-9]/','',$tdValue);
				break;
			}
		}
	}
	*/
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
			<input name="q" type="search" placeholder="書籍を検索">
			<input type="submit" value="">
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
								$stmt = $pdo->query("SELECT StoreName FROM Store WHERE StoreNum <> 0");
								
								foreach ($stmt as $row) {
									echo "<th>$row[StoreName]</th>";
									$storeCount++;
								}
							?>
						</tr>
						<tr>
							<?php
								for ($i = 1; $i <= $storeCount; $i++){
									$stmt = $pdo->query("SELECT StockAmount FROM Stock WHERE JANCode = $janCode AND StoreNum = $i");
								
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

				<h3>登録情報</h3>
				<table>
					<tr>
						<th>JANコード</th>
						<td><?php echo $janCode ?></td>
					</tr>
					<tr>
						<th>ISBN10</th>
						<td><?php echo $isbn10 ?></td>
					</tr>
				</table>
			</section>
		</div>

		<footer>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</footer>

	</body>

</html>
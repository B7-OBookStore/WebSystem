<?php
	require 'php/db_connect.php';

	$q = $_GET["q"];
	$startIndex = $_GET["startIndex"];
	$previousIndex = $_GET["previousIndex"];
	
	if ($q == NULL){
		header( "Location: index.php" ) ;
		exit;
	}
	
	if ($startIndex == NULL) {
		$startIndex = 0;
	}
	
	if ($previousIndex != NULL){
		$previousIndex = explode(",", $previousIndex);
	}
	
	$previousIndex[] = $startIndex;
	$nextIndex = $startIndex;
	
	$i = 0;
	$q_encoded = urlencode($q);
	$books = array();
	
	while ($i < 20) {
		$json = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=$q_encoded&startIndex=$nextIndex&maxResults=40&key=AIzaSyBczORlfI6MEmYnkTFwP5au6rq_oo4h92s");
		$results = json_decode($json, TRUE);
	
		if (count($results[items]) == NULL) {
			break;
		}
	
		foreach($results[items] as $j => $item) {
			if ($i >= 20) {
				break;
			}
	
			foreach ($item[volumeInfo][industryIdentifiers] as $k => $identifier) {
				if ($identifier[type] === "ISBN_13") {
					$books[] = $item;
					$i++;
				}
			}
			$nextIndex++;
		}
	}
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="css/search.css">
		<link rel="icon" href="img/favicon.ico">
		<title><?php echo $q ?> -O書店検索</title>
	</head>

	<body>

		<header>
			<h1><a href="index.php">O書店</a></h1>
			<span>Web注文機能を使うためには、ログインしてください</span>
			<a id="login" href="">ログイン</a>
		</header>

		<form id="search" method="get" action="search.php">
			<input name="q" type="search" placeholder="書籍を検索" value="<?php echo $q ?>">
			<input type="submit" value="">
		</form>

		<div id="main">
			<section id="option">
			(検索オプションとか)
			</section>

			<div id="result">
				<?php
					if (count($books) != 0) {
						foreach($books as $i => $book) {
							$id = $book[id];
							$title = $book[volumeInfo][title]." ".$book[volumeInfo][subtitle];
							$publishedDate = $book[volumeInfo][publishedDate];

							foreach ($book['volumeInfo']['industryIdentifiers'] as $identifier) {
								if ($identifier['type'] === 'ISBN_13') {
									$janCode = $identifier['identifier'];
									break;
								}
							}

							$stmt = $pdo->query("SELECT Price FROM Item WHERE JANCode = $janCode");
							if ($result = $stmt->fetch()) {
								$listPrice = $result[Price];
							} else {
								$listPrice = $book[saleInfo][listPrice][amount];
							}
					
							$authors = NULL;
							foreach($results[volumeInfo][authors] as $i => $author) {
								$authors = $authors.$author.",";
							}
							$authors = rtrim($authors,',');
					
							if ($book[volumeInfo][imageLinks][thumbnail] == NULL) {
								$thumbnail = "img/noimage.png";
							} else {
								$thumbnail = $book[volumeInfo][imageLinks][thumbnail];
							}
				?>
				<section>
					<a href="<?php echo "book.php?id=$id" ?>"></a>
					<img alt="<?php echo $title ?>" src="<?php echo $thumbnail ?>">

					<div>
						<h2><?php echo $book[volumeInfo][title] ?></h2>
						<p class="publishedDate"><?php echo $publishedDate ?></p>

						<p><?php echo $authors ?></p>

						<?php
							if ($listPrice !== NULL) {
								echo "<p class='price'>￥ $listPrice</p>";
							}
						?>
					</div>
				</section>
				<?php
						}
					} else {
						echo "<section>見つかりませんでした。</section>";
					}
				?>

				<nav>
					<div>
						<?php
							if ($startIndex != 0) {
								echo "<a class='button' href='search.php?q=$q'>最初へ</a>";
							}
							if (count($previousIndex) > 1) {
								echo "<a class='button' href='search.php?q=$q&startIndex=$previousIndex'>前へ</a>";
							}
						?>
					</div>
					<div>
						<?php
							$previousIndex = implode(",", $previousIndex);
							if (count($books) == 20) {
								echo "<a class='button' href='search.php?q=$q&startIndex=$nextIndex&previousIndex=$previousIndex'>次へ</a>";
							}
						?>
					</div>
				</nav>
			</div>
		</div>

		<footer>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</footer>

	</body>

</html>
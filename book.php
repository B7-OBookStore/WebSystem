<?php
$id = $_GET["id"];

if ($id == NULL){
	header( "Location: index.php" ) ;
	exit;
}

$json = file_get_contents("https://www.googleapis.com/books/v1/volumes/$id?key=AIzaSyBczORlfI6MEmYnkTFwP5au6rq_oo4h92s");
$results = json_decode($json, TRUE);

$title = $results[volumeInfo][title]." ".$results[volumeInfo][subtitle];
$publishedDate = $results[volumeInfo][publishedDate];
$description = $results[volumeInfo][description];
$publisher = $results[volumeInfo][publisher];
$categories = $results[volumeInfo][categories];

if ($results[saleInfo][listPrice][amount] == NULL) {
	$listPrice = "(注文確定後にお知らせ)";
} else {
	$listPrice = $results[saleInfo][listPrice][amount];
}

foreach($results[volumeInfo][authors] as $i => $author) {
	$authors = $authors.$author."　";
}

if ($results[volumeInfo][imageLinks][small] == NULL){
	if ($results[volumeInfo][imageLinks][thumbnail] == NULL){
		$imageLink = "img/noimage.png";
	} else {
		$imageLink = $results[volumeInfo][imageLinks][thumbnail];
	}
} else {
	$imageLink = $results[volumeInfo][imageLinks][small];
}

/*
// ISBN取得の成りそこない(やたら重い
$feed = simplexml_load_file("https://www.google.com/books/feeds/volumes/".$id);
$isbn = $feed->children("http://purl.org/dc/terms")->identifier;
$isbn10 = preg_grep("/^ISBN:[0-9]{10}$/",(array)$isbn);
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
			<input name="q" type="search" placeholder="書籍を検索"><!--
			--><input  type="submit" value="">
	</form>

	<div id="main">
		<section id="container">
			<img alt="<?php echo $title ?>" src="<?php echo $imageLink ?>">

			<div>
				<a id="add" class="button" href="cart.php?id=<?php echo $id ?>">カートに追加</a>

				<h2><?php echo $title ?></h2>

				<p class="publishedDate"><?php echo $publishedDate ?></p>
				<p><?php echo $authors ?></p>
				<p class="price">￥ <?php echo $listPrice ?></p>

				<h3>在庫状況</h3>
				<table>
					<tr>
						<th>本店</th>
						<th>駅前店</th>
						<th>工大前店</th>
						<th>県庁通店</th>
						<th>プラザ店</th>
						<th>山環状店</th>
					</tr>
					<tr>
						<td>○</td>
						<td>×</td>
						<td>○</td>
						<td>○</td>
						<td>○</td>
						<td>×</td>
					</tr>
				</table>
			</div>
		</section>

		<section id="info">
			<h3>商品説明</h3>
			<p><?php echo $description ?></p>

			<h3>ジャンル</h3>
			<?php foreach($categories as $i => $category) {
				echo "<p>$category</p>";
			} ?>

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
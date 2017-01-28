<?php
	$q = htmlspecialchars($_GET["q"], ENT_QUOTES, 'UTF-8');
	$mode = htmlspecialchars($_GET["mode"], ENT_QUOTES, 'UTF-8');
	$startIndex = htmlspecialchars($_GET["startIndex"], ENT_QUOTES, 'UTF-8');
	$previousIndex = htmlspecialchars($_GET["previousIndex"], ENT_QUOTES, 'UTF-8');
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

	<?php
		// ヘッダ表示部分
		require 'php/header.php';
	?>

	<?php
		// 検索
		require 'php/db_connect.php';
		require 'php/searchManager.php';
	?>

		<form id="search" method="get" action="search.php">
			<input type="hidden" name="mode" value="<?php echo $mode ?>">
			<input name="q" type="search" placeholder="書籍を検索" value="<?php echo $q ?>">
			<input type="submit" value="">
		</form>

		<div id="main">
			<section id="option">
				<?php
					if ($mode == 'book' || $mode == NULL) {
						echo '<p class="bold">書籍</p>';
						echo "<p><a href='search.php?q=$q&mode=other'>その他</a></p>";
					} else if ($mode == 'other') {
						echo "<p><a href='search.php?q=$q&mode=book'>書籍</a></p>";
						echo '<p class="bold">その他</p>';
					}
				?>
			</section>

			<div id="result">
				<?php
					if (($mode == 'book' || $mode == NULL) && count($books) != 0) {
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
					} else if ($mode == 'other' && $other=$others->fetch()) {
						do {
				?>
					<section>
						<a href="<?php echo "other.php?janCode=$other[JANCode]" ?>"></a>
						<?php
							if ($other[Genre] == "TVゲーム") {
								echo '<img alt="ゲーム" src="img/tvgame.png">';
							} else if ($other[Genre] == "CD") {
								echo '<img alt="CD" src="img/cd.png">';
							} else {
								echo '<img alt="その他" src="img/other.png">';
							}
						?>

						<div>
							<h2><?php echo $other[Name] ?></h2>
							<p><?php echo $other[Manufacturer] ?></p>

							<?php
								if ($other[Price] !== NULL) {
									echo "<p class='price'>￥ $other[Price]</p>";
								}
							?>
						</div>
					</section>
				<?php
						} while($other=$others->fetch());
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
								$formerPreviousIndex = $previousIndex;
								$formerStartIndex = array_pop($formerPreviousIndex);
								$formerPreviousIndex = implode(",", $formerPreviousIndex);

								echo "<a class='button' href='search.php?q=$q&startIndex=$formerStartIndex&previousIndex=$formerPreviousIndex'>前へ</a>";
							}
						?>
					</div>
					<div>
						<?php
							$previousIndexNext = implode(",", $previousIndexNext);
							if (count($books) == 20) {
								echo "<a class='button' href='search.php?q=$q&startIndex=$nextIndex&previousIndex=$previousIndexNext'>次へ</a>";
							}
						?>
					</div>
				</nav>
			</div>
		</div>

		<footer>
			<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
		</footer>

	</body>

</html>
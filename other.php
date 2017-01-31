<?php
	// データベースに接続
	require 'php/db_connect.php';
	require 'php/cls_Book.php';

	// GETでGoogleBooksのIDを取得
	$janCode = htmlspecialchars($_GET["janCode"], ENT_QUOTES, 'UTF-8');

	if ($janCode == NULL) {
		header( "Location: index.php" );
		exit;
	}

	$stmt = $pdo->query("SELECT Other.JANCode,Price,Name,Manufacturer,Genre FROM Item INNER JOIN Other ON Item.JANCode=Other.JANCode WHERE Other.JANCode = :jancode");
	$stmt->bindParam(':jancode', $janCode, PDO::PARAM_STR);
	$stmt->execute();
	
	if (!$other = $stmt->fetch()){
		header( "Location: index.php" );
		exit;
	}
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="keywords" content="<?php echo $other[Name] ?>">
		<link rel="stylesheet" href="css/book.css">
		<link rel="icon" href="img/favicon.ico">
		<title><?php echo $other[Name] ?> - O書店</title>
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
					<p class="price">￥ <?php
						if ($other[Price] == NULL){
							echo "(注文確定後にお知らせ)";
						} else {
							echo $other[Price];
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
								$stmt = $pdo->prepare("SELECT Store.StoreNum,StockAmount FROM Store LEFT JOIN Stock ON Store.StoreNum = Stock.StoreNum AND JANCode = :jancode WHERE Store.StoreNum <> 0 ORDER BY Store.StoreNum");
								$stmt->bindParam(':jancode', $janCode, PDO::PARAM_STR);
								$stmt->execute();

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
					if ($other[Genre] != NULL){
						echo '<h3>ジャンル</h3>';
						echo "<p>$other[Genre]</p>";
					}
				?>

				<h3>販売元</h3>
				<p><?php echo $other[Manufacturer] ?></p>

				<h3>登録情報</h3>
				<table>
					<tr>
						<th>JANコード</th>
						<td><?php echo $janCode ?></td>
					</tr>
				</table>
			</section>
		</div>

		<footer>
			<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
		</footer>

	</body>

</html>
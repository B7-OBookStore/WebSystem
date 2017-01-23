<?php
	require 'php/db_connect.php';

	$storeNum = $_POST['storeNum'];

	$stmt = $pdo->query("SELECT StoreName FROM Store WHERE StoreNum=$storeNum");
	if ($result = $stmt->fetch()) {
		$storeName = $result[StoreName];
	}
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="css/order_check.css">
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
			<section>
				<h2>注文確認</h2>
				<div id="list">
					<h3>注文内容</h3>
					<table>
						<tr>
							<th>タイトル</th>
							<th>価格</th>
						</tr>
						<?php
							$userID = $_SESSION['UserID'];
							$stmt = $pdo->query("SELECT Book.JANCode,Price,BookTitle,Writer,GoogleID FROM Cart INNER JOIN Item ON Cart.JANCode = Item.JANCode INNER JOIN Book ON Cart.JANCode = Book.JANCode INNER JOIN User ON Cart.UserNum = User.UserNum WHERE UserID = '$userID'");

							foreach ($stmt as $row) {
						?>
						<tr>
							<td><?php echo $row[BookTitle] ?></td>
							<td>
							<?php
								if ($row[Price] == NULL){
									echo "注文確定後にお知らせ";
								} else {
									echo "￥ ".$row[Price];
								}
							?>
							</td>
						</tr>
						<?php
							}
						?>
					</table>

					<h3>受取書店</h3>
					<p><?php echo $storeName ?></p>

					<form action="ordered.php" method="post">
						<input type="hidden" name="storeNum" value="<?php echo $storeNum ?>">
						<input class="button" type="submit" value="注文">
					</form>
				</div>

				<img id="character" alt="O書店公式キャラクター ショモツムリ" src="<?php
					$stmt = $pdo->query("SELECT count(*) FROM Cart INNER JOIN User ON Cart.UserNum=User.UserNum WHERE UserID = '$userID'");
					$count = $stmt->fetchColumn();

					if ($count < 5) {
						echo 'img/order_check_syomotsumuri.png';
					} else {
						echo 'img/order_check_syomotsumuri_heavy.png';
					}
				?>">
			</section>
		</div>

		<footer>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</footer>

	</body>

</html>
<?php
	require 'php/db_connect.php';

	$storeNum = htmlspecialchars($_POST['storeNum'], ENT_QUOTES, 'UTF-8');

	if ($storeNum == NULL) {
		header( "Location: index.php" ) ;
		exit;
	}

	$stmt = $pdo->prepare("SELECT StoreName FROM Store WHERE StoreNum = :storenum");
	$stmt->bindParam(':storenum', $storeNum, PDO::PARAM_INT);
	$stmt->execute();

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
		<title>注文 - O書店</title>
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
						<input type="hidden" name="Token" value="<?php echo htmlspecialchars($_SESSION['Token'], ENT_QUOTES, 'UTF-8'); ?>">
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
			<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
		</footer>

	</body>

</html>
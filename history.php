<?php
	require 'php/db_connect.php';

	$filter = $_GET['filter'];
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="css/history.css">
		<link rel="icon" href="img/favicon.ico">
		<title></title>
	</head>

	<body>

		<?php
			// ヘッダ表示部分
			require 'php/header.php';
		?>

		<form id="search" method="get" action="search.php">
			<input type="hidden" name="mode" value="<?php echo $mode ?>">
			<input name="q" type="search" placeholder="書籍を検索" value="<?php echo $q ?>">
			<input type="submit" value="">
		</form>

		<div id="main">
			<section id="option">
				<h2>注文履歴</h2>
				<?php
					if ($filter == NULL) {
						echo '<p class="bold">全て</p>';
					} else {
						echo '<p><a href="history.php">全て</a></p>';
					}
					if ($filter == 'unreceived') {
						echo '<p class="bold">未受け取り</p>';
					} else {
						echo '<p><a href="history.php?filter=unreceived">未受け取り</a></p>';
					};
					if ($filter == 'received') {
						echo '<p class="bold">受取済</p>';
					} else {
						echo '<p><a href="history.php?filter=received">受取済</a></p>';
					}
				?>
			</section>

			<div id="result">
				<?php
					$userID = $_SESSION['UserID'];
					switch ($filter) {
						case 'unreceived':
							$where = 'AND ReceiptStat=false';
							break;
						case 'received':
							$where = 'AND ReceiptStat=true';
							break;
					}
					$requests = $pdo->query("SELECT * FROM Request INNER JOIN User ON Request.UserNum=User.UserNum INNER JOIN Store ON Request.StoreNum=Store.StoreNum WHERE UserID='$userID' $where ORDER BY RequestNum DESC");
					
					foreach ($requests as $request) {
				?>
				<section>
					<h3>注文番号：<?php echo $request[RequestNum] ?></h3>
					<table class="request">
						<tr>
							<th>受取店舗</th>
							<td><?php echo $request[StoreName] ?></td>
						</tr>
						<tr>
							<th>受取期限</th>
							<td>
								<?php
									if ($request[ReceiptLimit] == NULL) {
										echo '未確定(全品揃った時点で確定します)';
									} else {
										echo $request[ReceiptLimit];
									}
								?>
							</td>
						</tr>
						<tr>
							<th>受取状態</th>
							<td>
								<?php
									if ($request[ReceiptStat]) {
										echo '全て受け取り済み';
									} else {
										echo '受け取っていない書籍があります';
									}
								?>
							</td>
						</tr>
					</table>
					<?php
						$requestDetails = $pdo->prepare("SELECT RequestDetail.JANCode,DeliveryStat,Price,BookTitle,Writer,Publisher,GoogleID FROM RequestDetail
							INNER JOIN Item ON RequestDetail.JANCode=Item.JANCode INNER JOIN Book ON RequestDetail.JANCode=Book.JANCode
							WHERE RequestNum = :request");
						$requestDetails->bindParam(':request', $request[RequestNum], PDO::PARAM_INT);
						$requestDetails->execute();
						
						foreach ($requestDetails as $requestDetail) {
					?>
					<section class="item">
						<img alt="<?php echo $requestDetail[BookTitle] ?>" src="http://books.google.com/books/content?id=<?php echo $requestDetail[GoogleID] ?>&printsec=frontcover&img=1&zoom=5&source=gbs_api">

						<div class="info">
							<h4><?php echo $requestDetail[BookTitle] ?></h4>
							<p>
								<?php
									switch ($requestDetail[DeliveryStat]) {
										case 0:
											echo '注文を確認中';
											break;
										case 1:
											echo '在庫不足のため、出版社に発注しました。';
											break;
										case 2:
											echo '出版社から配送中';
											break;
										case 3:
											echo '取り置き中。ご来店をお待ちしています';
											break;
										case 4:
											echo 'お受け取り済み';
											break;
									}
								?>
							</p>
							<p class="price">￥
								<?php
									if ($requestDetail[Price] == NULL){
										echo "(注文確定後にお知らせ)";
									} else {
										echo $requestDetail[Price];
									}
								?></p>
						</div>
					</section>
					<?php
						}
					?>
				</section>
				<?php
					}
				?>
			</div>
		</div>

		<footer>
			<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
		</footer>

	</body>

</html>
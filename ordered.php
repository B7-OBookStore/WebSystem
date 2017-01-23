<?php
	require 'php/db_connect.php';

	$storeNum = $_POST['storeNum'];
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="css/ordered.css">
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
				<div>
				<?php
					$userID = $_SESSION['UserID'];
					
					$stmt = $pdo->query("SELECT Count(*) FROM Request");
					$requestNum = $stmt->fetchColumn();
					
					$sql = 'INSERT INTO Request SELECT :RequestNum,:StoreNum,NULL,FALSE,UserNum,CONCAT(LastName,FirstName),Phone,ZipCode,Pref,City,Address,Apartment FROM User WHERE UserID=:UserID';
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':RequestNum',$requestNum);
					$stmt->bindParam(':StoreNum',$storeNum);
					$stmt->bindParam(':UserID',$userID);
					$result = $stmt->execute();
					
					if ($result) {
						$items = $pdo->query("SELECT JANCode FROM Cart INNER JOIN User ON Cart.UserNum=User.UserNum WHERE UserID='$userID'");
						$sql = 'INSERT INTO RequestDetail VALUES(:RequestNum,:RequestDetNum,:JANCode,0)';
						$stmt = $pdo->prepare($sql);

						foreach ($items as $i => $item) {
							$stmt->bindParam(':RequestNum',$requestNum);
							$stmt->bindParam(':RequestDetNum',$i);
							$stmt->bindParam(':JANCode',$item[JANCode]);
							$stmt->execute();
						}

						echo '<h2>注文完了</h2>';
						echo '<p>ご注文ありがとうございます。今後ともO書店をよろしくお願いします。</p>';
					} else {
						echo '<h2>注文に失敗しました</h2>';
						echo '<p>注文処理に失敗しました。申し訳ありませんが、再度注文をよろしくお願いいたします。</p>';
					}
				?>

				<a class="button" href="">トップに戻る</a>
				</div>

				<img id="" alt="O書店公式キャラクター 石蕗クミコ" src="img/ordered_kumiko.png">
			</section>
		</div>

		<footer>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</footer>

	</body>

</html>
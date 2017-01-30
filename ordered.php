<?php
require 'php/db_connect.php';
$storeNum = htmlspecialchars($_POST['storeNum'], ENT_QUOTES, 'UTF-8');
if ($storeNum == NULL) {
	header( "Location: index.php" ) ;
	exit;
}
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
			$stmt = $pdo->query("SELECT count(*) FROM Cart INNER JOIN User ON Cart.UserNum=User.UserNum WHERE UserID = '$userID'");
			$count = $stmt->fetchColumn();
			if ($count == 0) {
				header( "Location: index.php" ) ;
				exit;
			}

			$stmt = $pdo->query("SELECT Count(*) FROM Request");
			$requestNum = $stmt->fetchColumn();

			$sql = 'INSERT INTO Request SELECT :RequestNum,:StoreNum,NULL,FALSE,UserNum,CONCAT(LastName,FirstName),Phone,ZipCode,Pref,City,Address,Apartment FROM User WHERE UserID=:UserID';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':RequestNum',$requestNum);
			$stmt->bindParam(':StoreNum',$storeNum);
			$stmt->bindParam(':UserID',$userID);
			$result = $stmt->execute();

			if ($result) {
				$items = $pdo->query("SELECT Cart.JANCode,BookTitle FROM Cart INNER JOIN Book ON Cart.JANCode=Book.JANCode INNER JOIN User ON Cart.UserNum=User.UserNum WHERE UserID='$userID'");
				$sql = 'INSERT INTO RequestDetail VALUES(:RequestNum,:RequestDetNum,:JANCode,0)';
				$stmt = $pdo->prepare($sql);
				foreach ($items as $i => $item) {
					$orderList .= "\n注文$i)\n$item[BookTitle]\n";
					$stmt->bindParam(':RequestNum',$requestNum);
					$stmt->bindParam(':RequestDetNum',$i);
					$stmt->bindParam(':JANCode',$item[JANCode]);
					$stmt->execute();
				}
				$sql = 'DELETE Cart FROM Cart INNER JOIN User ON Cart.UserNum = User.UserNum WHERE UserID=:UserID';
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':UserID', $_SESSION['UserID']);
				$stmt->execute();

				$stmt = $pdo->query("SELECT * FROM User,Store WHERE UserID='$userID' AND StoreNum=$storeNum");
				if ($user = $stmt->fetch()) {
					require 'php/mailManager.php';
					$body = "$user[LastName] $user[FirstName] 様\nお客様の客注を受け付けました。注文内容は以下の通りです。\n\n"
						."受取店舗：$user[StoreName]\n客注番号：$requestNum\n$orderList\nお取り置きが完了いたしましたら、追って連絡いたします。\n"
						."なお、絶版などの理由により、ご注文の書籍を用意できない場合も\nございますのでご了承ください。\n\n"
						."-------------------------------------------------\nI県K市 O書店";
					sendMail($user[Mail],'O書店 注文完了のお知らせ',$body);
				}

				echo '<h2>注文完了</h2>';
				echo '<p>ご注文ありがとうございます。今後ともO書店をよろしくお願いします。</p>';
			} else {
				echo '<h2>注文に失敗しました</h2>';
				echo '<p>注文処理に失敗しました。申し訳ありませんが、再度注文をよろしくお願いいたします。</p>';
			}
			?>

			<a class="button" href="index.php">トップに戻る</a>
		</div>

		<img id="character" alt="O書店公式キャラクター 石蕗クミコ" src="img/ordered_kumiko.png">
	</section>
</div>

<footer>
	<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
</footer>

</body>

</html>
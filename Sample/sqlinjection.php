<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="../css/information.css">
	<link rel="icon" href="img/favicon.ico">
	<title>O書店</title>
</head>

<body>

<header>
	<h1><a href="index.php">O書店</a></h1>
</header>

<div id="main">
	<section>
		<h2>SQLインジェクションテスト</h2>
		<p>ユーザデータを表示します。</p>
		<form method="post" action="sqlinjection.php">
			<input type="text" name="us">
			<input type="text" name="pa">
			<input type="submit" value="送信">
		</form>
	</section>

	<section>
		<?php
			if(!empty($_POST['us'])){
				$us = $_POST['us'];
				$pa = $_POST['pa'];

				require '../php/db_connect.php';
				$sql = "SELECT * FROM User WHERE UserID = '$us' AND Password = '$pa'";
				$stmt = $pdo->query($sql);
				echo $stmt->queryString;

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					echo '<p>';
					echo 'UserID : '.$row['UserID'];
					echo '    Password : '.$row['Password'];
					echo '</p>';
				}
			}
		?>
	</section>



	<section>
		<h2>ヤバいコードをパスワードの部分に入力すると…</h2>
		<p>SQLはこうなってる気がする ... SELECT * FROM User WHERE UserID = '$user' AND Password = '$pass'</p>
		<p>例1 .. <?php echo htmlspecialchars("aaa' OR 'HOGE' = 'HOGE", ENT_QUOTES, 'UTF-8'); ?></p>
	</section>

</div>

<footer>
	<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
</footer>
</body>

</html>
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
				<h2>XSSテスト</h2>
				<p>君の名は？</p>
				<form method="post" action="xss.php">
					<input type="text" name="yourname">
					<input type="submit" value="送信">
				</form>
				<p>あなたの名前は <?php echo $_POST['yourname']; ?> です。</p>
			</section>

			<section>
				<?php
					// XSS例表示用に
					$exp1 = htmlspecialchars('<script>alert("XSS Detected!");</script>', ENT_QUOTES, 'UTF-8');
					$exp2 = htmlspecialchars('<script>window.location.href = "https://www.google.co.jp";</script>', ENT_QUOTES, 'UTF-8');
				?>
				<p>例1 ... <?php echo $exp1;?></p>
				<p>例2 ... <?php echo $exp2;?></p>
			</section>

		</div>

		<footer>
			<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
		</footer>
	</body>

</html>
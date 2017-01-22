<?php
// データベースに登録情報を送信
require 'php/db_connect.php';

// 挿入用データを変数に格納
$FirstName = $_POST['FirstName'];
$LastName = $_POST['LastName'];
$YomiFirst = $_POST['YomiFirst'];
$YomiLast = $_POST['YomiLast'];
$Phone = $_POST['Phone'];
$Mail = $_POST['Mail'];
$UserID = $_POST['UserID'];
$Password = $_POST['Password'];
$Birth = $_POST['Birth'];
$Gender = $_POST['Gender'] == 'male' ? true : false;
$ZipCode = $_POST['ZipCode'];
$Pref = $_POST['Pref'];
$City = $_POST['City'];
$Address = $_POST['Address'];
$Apartment = $_POST['Apartment'];

// データベースに挿入
$st->$pdo->prepare("INSERT INTO User(FirstName, LastName, YomiFirst, YomiLast, Phone, Mail,
						UserID, Password, Birth, Gender, ZipCode, Pref, City, Address, Apartment) VALUES
						 (:firstname, :lastname, :yomifirst, :yomilast, :phone, :mail,
						 :userid, :password, :birth, :gender, :zipcode, :pref, :city, :address, :apartment)");
$st->bindParam(':firstname', $FirstName, PDO::PARAM_STR);
$st->bindParam(':lastname', $LastName, PDO::PARAM_STR);
$st->bindParam(':yomifirst', $YomiFirst, PDO::PARAM_STR);
$st->bindParam(':yomilast', $YomiLast, PDO::PARAM_STR);
$st->bindParam(':phone', $Phone, PDO::PARAM_STR);
$st->bindParam(':mail', $Mail, PDO::PARAM_STR);
$st->bindParam(':userid', $UserID, PDO::PARAM_STR);
$st->bindParam(':password', $Password, PDO::PARAM_STR);
$st->bindParam(':birth', $Birth, PDO::PARAM_STR);
$st->bindParam(':gender', $Gender, PDO::PARAM_BOOL);
$st->bindParam(':zipcode', $ZipCode, PDO::PARAM_STR);
$st->bindParam(':pref', $Pref, PDO::PARAM_STR);
$st->bindParam(':city', $City, PDO::PARAM_STR);
$st->bindParam(':address', $Address, PDO::PARAM_STR);
$st->bindParam(':apartment', $Apartment, PDO::PARAM_STR);

// エラったとき用　念の為
try {
	$st->execute();
} catch (PDOException $e) {
	echo 'Error!  :  ' . $e->getMessage() . '<br>';
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="widh3=device-widh3,initial-scale=1">
	<link rel="stylesheet" href="css/register.css">
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
	<input name="q" type="search" placeholder="書籍を検索">
	<input type="submit" value="">
</form>

<div id="main">
	<section>

		<?php
		try {
			$st->execute();

			// 挿入に成功したら以下の文を表示
			echo '<h2>会員登録が完了しました</h2>';
			echo '<p>登録ありがとうございます。今後ともO書店をよろしくお願いします。</p>';

		} catch (PDOException $e) {

			// 挿入に失敗したら以下の文を表示
			echo '<h2>会員登録に失敗しました</h2>';
			echo '<p>会員登録処理に失敗しました。申し訳ありませんが、再度登録をお願いします。</p>';

			// エラー内容表示(Debug)
			// echo 'Error!  :  ' . $e->getMessage() . '<br>';
		}
		?>

		<img id="character" alt="O書店公式キャラクター 羽名しおりちゃん" src="img/register_shiori.png">
	</section>

</div>

<footer>
	<a href="">規約</a>
	<a href="">プライバシー</a>
	<a href="">店舗</a>
</footer>

</body>

</html>
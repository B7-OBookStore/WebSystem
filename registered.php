<?php
// データベースに登録情報を送信
require 'php/db_connect.php';

session_start();

// 挿入用データを変数に格納
$FirstName = $_SESSION['regFirstName'];
$LastName = $_SESSION['regLastName'];
$YomiFirst = $_SESSION['regYomiFirst'];
$YomiLast = $_SESSION['regYomiLast'];
$Phone = $_SESSION['regPhone'];
$Mail = $_SESSION['regMail'];
$UserID = $_SESSION['regUserID'];
$Password = $_SESSION['regPassword'];
// 暗号化したらこっちに変更
// $Password = password_hash($_SESSION['regPassword'], PASSWORD_DEFAULT);
$Birth = $_SESSION['regBirth'];
$Gender = $_SESSION['regGender'] == 'male' ? true : false;
$ZipCode = $_SESSION['regZipCode'];
$Pref = $_SESSION['regPref'];
$City = $_SESSION['regCity'];
$Address = $_SESSION['regAddress'];
$Apartment = $_SESSION['regApartment'];

// 格納し終わったらSession変数を空にして放棄
$_SESSION = array();
session_destroy();

// データベースに挿入
$st = $pdo->prepare("INSERT INTO User(FirstName, LastName, YomiFirst, YomiLast, Phone, Mail,
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
			$st->execute();
			$error = $st->errorInfo();

			// DB挿入エラーチェック
			if($error[0] = '00000' && $error[1] == NULL && $error[2] == NULL) {
				// 挿入に成功したら以下の文を表示
				echo '<h2>会員登録が完了しました</h2>';
				echo '<p>登録ありがとうございます。今後ともO書店をよろしくお願いします。</p>';

			} else {
				// 挿入に失敗したら以下の文を表示
				echo '<h2>会員登録に失敗しました</h2>';
				echo '<p>会員登録処理に失敗しました。申し訳ありませんが、再度登録をお願いします。</p>';
			}

		?>
	</section>

</div>

<footer>
	<a href="">規約</a>
	<a href="">プライバシー</a>
	<a href="">店舗</a>
</footer>

</body>

</html>
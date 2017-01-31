<?php
// データベースに登録情報を送信
require 'php/db_connect.php';

session_start();

require 'php/tokenManager.php';

// 挿入用データを変数に格納
$FirstName = $_SESSION['regFirstName'];
$LastName = $_SESSION['regLastName'];
$YomiFirst = $_SESSION['regYomiFirst'];
$YomiLast = $_SESSION['regYomiLast'];
$Phone = $_SESSION['regPhone'];
$Mail = $_SESSION['regMail'];
$UserID = $_SESSION['regUserID'];
// 暗号化したのでこっちはコメントアウト
// $Password = $_SESSION['regPassword'];
$Password = password_hash($_SESSION['regPassword'], PASSWORD_DEFAULT);
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
	<link rel="stylesheet" href="css/registration.css">
	<link rel="icon" href="img/favicon.ico">
	<title>会員登録 - O書店</title>
</head>

<body>

<header>
	<h1><a href="index.php">O書店</a></h1>
</header>

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

				require 'php/mailManager.php';
				$body = "$LastName $FirstName 様\n\n会員登録が完了しました。\n今後ともO書店をよろしくお願いします。\n\n"
				."登録に覚えがない場合：\nお手数ですが、support@obookstore.co.jpまでご連絡ください\n\n"
				."-------------------------------------------------\nI県K市 O書店";
				sendMail($Mail,'O書店 登録完了のお知らせ',$body);

			} else {
				// 挿入に失敗したら以下の文を表示
				echo '<h2>会員登録に失敗しました</h2>';
				echo '<p>会員登録処理に失敗しました。申し訳ありませんが、再度登録をお願いします。</p>';
			}

		?>
	</section>

</div>

<footer>
	<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
</footer>

</body>

</html>
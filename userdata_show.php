<?php
// セッション変数にデータを保存
session_start();

$FirstName = htmlspecialchars($_POST['FirstName'], ENT_QUOTES, 'UTF-8');
$LastName = htmlspecialchars($_POST['LastName'], ENT_QUOTES, 'UTF-8');
$YomiFirst = htmlspecialchars($_POST['YomiFirst'], ENT_QUOTES, 'UTF-8');
$YomiLast = htmlspecialchars($_POST['YomiLast'], ENT_QUOTES, 'UTF-8');
$Phone = htmlspecialchars($_POST['Phone'], ENT_QUOTES, 'UTF-8');
$Mail = htmlspecialchars($_POST['MailUser'].'@'.$_POST['MailDomain'], ENT_QUOTES, 'UTF-8');
$Password = password_hash(htmlspecialchars($_POST['Password'], ENT_QUOTES, 'UTF-8'), PASSWORD_DEFAULT);
$ZipCode = htmlspecialchars($_POST['ZipCode1'].$_POST['ZipCode2'], ENT_QUOTES, 'UTF-8');
$Pref = htmlspecialchars($_POST['pref'], ENT_QUOTES, 'UTF-8');
$City = htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8');
$Address = htmlspecialchars($_POST['Address'], ENT_QUOTES, 'UTF-8');
$Apartment = htmlspecialchars($_POST['Apartment'], ENT_QUOTES, 'UTF-8');
require 'php/db_connect.php';
$st = $pdo->prepare("UPDATE User SET FirstName = :firstname, LastName = :lastname, YomiFirst = :yomifirst,
						YomiLast = :yomilast, Phone = :phone, Mail = :mail, Password = :password, ZipCode = :zipcode,
						Pref = :pref, City = :city, Address = :address, Apartment = :apartment WHERE UserID = :userid");
$st->bindParam(':firstname', $FirstName, PDO::PARAM_STR);
$st->bindParam(':lastname', $LastName, PDO::PARAM_STR);
$st->bindParam(':yomifirst', $YomiFirst, PDO::PARAM_STR);
$st->bindParam(':yomilast', $YomiLast, PDO::PARAM_STR);
$st->bindParam(':phone', $Phone, PDO::PARAM_STR);
$st->bindParam(':mail', $Mail, PDO::PARAM_STR);
$st->bindParam(':password', $Password, PDO::PARAM_STR);
$st->bindParam(':zipcode', $ZipCode, PDO::PARAM_STR);
$st->bindParam(':pref', $Pref, PDO::PARAM_STR);
$st->bindParam(':city', $City, PDO::PARAM_STR);
$st->bindParam(':address', $Address, PDO::PARAM_STR);
$st->bindParam(':apartment', $Apartment, PDO::PARAM_STR);
$st->bindParam(':userid', $_SESSION['UserID'], PDO::PARAM_STR);
$st->execute();
$error = $st->errorInfo();
// ログインしていなかったら無理矢理index.phpに飛ばす
if (!isset($_SESSION['UserID'])) {
	header('Location: index.php');
	exit();
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="widh3=device-widh3,initial-scale=1">
	<link rel="stylesheet" href="css/registration_check.css">
	<link rel="icon" href="img/favicon.ico">
	<script src="js/register.js"></script>
	<script src="js/jquery-3.1.1.min.js"></script>
	<title>会員情報 - O書店</title>
</head>

<body>

<?php require 'php/header.php'; ?>

<div id="main">
	<section>
		<?php
		if($error[0] == '00000' && $error[1] == NULL && $error[2] == NULL) {
			echo '<h2>会員情報の変更が完了しました。</h2>';
		} else {
			echo '<h2>会員情報の更新に失敗しました。お手数ですが最初の手順から行ってください。</h2>';
		}
		?>
				<div id="form" class="vertical">

				<div id="password" class="horizontal">
					<h3>パスワード</h3>
					<div>
						<p><?php
							for($i = 0; $i < strlen($_POST['Password']); $i++){
								echo '*';
							}
							?></p>
						<p>セキュリティのためパスワードは伏字になっています。</p>
					</div>
				</div>


				<div id="name" class="horizontal">
					<h3>氏名</h3>
					<div>
						<p><?php echo htmlspecialchars($_POST['LastName'] . '  ' . $_POST['FirstName'], ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
				</div>

				<div id="phonetic" class="horizontal">
					<h3>フリガナ</h3>
					<div>
						<p><?php echo htmlspecialchars($_POST['YomiLast'] . '  ' . $_POST['YomiFirst'], ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
				</div>

				<div id="phonenumber" class="horizontal">
					<h3>電話番号</h3>
					<div>
						<p><?php echo htmlspecialchars($_POST['Phone'], ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
				</div>

				<div id="mailaddress" class="horizontal">
					<h3>メールアドレス</h3>
					<div>
						<p><?php echo htmlspecialchars($_POST['MailUser'].'@'.$_POST['MailDomain'], ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
				</div>

				<div id="address" class="horizontal">
					<h3>住所</h3>

					<div>
						<div>
							<h4>郵便番号</h4>
							<p><?php echo htmlspecialchars($_POST['ZipCode1'].'-'.$_POST['ZipCode2'], ENT_QUOTES, 'UTF-8'); ?></p>
						</div>

						<div>
							<h4>都道府県</h4>
							<p><?php echo htmlspecialchars($_POST['pref'], ENT_QUOTES, 'UTF-8'); ?>
						</div>

						<div>
							<h4>市区町村</h4>
							<p><?php echo htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8'); ?></p>
						</div>

						<div>
							<h4>番地</h4>
							<p><?php echo htmlspecialchars($_POST['Address'], ENT_QUOTES, 'UTF-8'); ?></p>
						</div>
						<div>
							<p><?php echo htmlspecialchars($_POST['Apartment'], ENT_QUOTES, 'UTF-8'); ?></p>
						</div>
					</div>
				</div>

			</div>

		<img id="character" alt="O書店公式キャラクター 羽名しおりちゃん" src="img/register_shiori.png">
	</section>

</div>

<footer>
	<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
</footer>

</body>

</html>
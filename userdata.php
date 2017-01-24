<?php
// セッション
session_start();
// ログインしていなかったら無理矢理index.phpに飛ばす
if (!isset($_SESSION['UserID'])) {
	header('Location: index.php');
	exit();
}
// データベース準備
require 'php/db_connect.php';
$st = $pdo->prepare("SELECT FirstName, LastName, YomiFirst, YomiLast, Phone, Mail, ZipCode, Pref, City, Address, Apartment
					FROM User WHERE UserID = :userid");
$st->bindParam(':userid', $_SESSION['UserID'], PDO::PARAM_STR);
$st->execute();
// 変数に値を格納
$result = $st->fetch(PDO::FETCH_ASSOC);
$replaced = '';
// メールユーザを抽出する正規表現
preg_match('/^[\w\.\-]+/', $result['Mail'], $replaced);
$resultMailUser = $replaced[0];
// メールドメインを抽出する正規表現
preg_match('/[\w\.\-]+$/', $result['Mail'], $replaced);
$resultMailDomain = $replaced[0];
// 郵便番号前半を抽出する正規表現
preg_match('/^.{3}/', $result['ZipCode'], $replaced);
$resultZipCode1 = $replaced[0];
// 郵便番号後半を抽出する正規表現
preg_match('/.{4}$/', $result['ZipCode'], $replaced);
$resultZipCode2 = $replaced[0];
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="widh3=device-widh3,initial-scale=1">
	<link rel="stylesheet" href="css/registration.css">
	<link rel="icon" href="img/favicon.ico">
	<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
	<script src="js/jquery-3.1.1.min.js"></script>
	<title>O書店</title>
</head>

<body>

<?php require 'php/header.php'; ?>

<form id="search" method="get" action="search.php">
	<input name="q" type="search" placeholder="書籍を検索">
	<input type="submit" value="">
</form>

<div id="main">
	<section>
		<h2>会員情報変更</h2>
		<form id="registerForm" action="userdata_show.php" method="post">
			<div id="form" class="vertical">

				<div id="password" class="horizontal">
					<h3>パスワード</h3>
					<div>
						<input class="formPass" id="formPass1" type="password" name="Password" maxlength="8" required>
						<small>8文字以上</small>
					</div>
				</div>

				<div id="password" class="horizontal">
					<h3>パスワード再入力</h3>
					<div>
						<input class="formPass" id="formPass2" type="password2" name="Password2" maxlength="8" required>
						<small id="checkPass"></small>
					</div>
				</div>

				<div id="name" class="horizontal">
					<h3>氏名</h3>
					<div>
						<div class="horizontal">
							<div>
								<h4>姓</h4>
								<input type="text" name="LastName" value="<?php echo $result['LastName']; ?>" required>
								<small>(例) 静岡</small>
							</div>
							<div>
								<h4>名</h4>
								<input type="text" name="FirstName" value="<?php echo $result['FirstName']; ?>"
								       required>
								<small>(例) 太郎</small>
							</div>
						</div>
					</div>
				</div>

				<div id="phonetic" class="horizontal">
					<h3>フリガナ</h3>
					<div>
						<div class="horizontal">
							<div>
								<h4>姓</h4>
								<input type="text" name="YomiLast" value="<?php echo $result['YomiLast']; ?>" required>
								<small>(例) シズオカ</small>
							</div>
							<div>
								<h4>名</h4>
								<input type="text" name="YomiFirst" value="<?php echo $result['YomiFirst']; ?>"
								       required>
								<small>(例) タロウ</small>
							</div>
						</div>
					</div>
				</div>


				<div id="phonenumber" class="horizontal">
					<h3>電話番号</h3>
					<div>
						<input id="formPhone" type="text" name="Phone" maxlength="11"
						       value="<?php echo $result['Phone']; ?>" required>
						<small id="checkPhone">(例) 12345678910</small>
					</div>
				</div>

				<div id="mailaddress" class="horizontal">
					<h3>メールアドレス</h3>
					<div>
						<div class="horizontal"><input class="formMail" id="formMail1" type="text" name="MailUser"
						                               value="<?php echo $resultMailUser; ?>" required>
							<p>@</p><input class="formMail" id="formMail2" type="text" name="MailDomain"
							               value="<?php echo $resultMailDomain; ?>" required>
						</div>
						<small id="checkMail"></small>
					</div>
				</div>

				<div id="address" class="horizontal">
					<h3>住所</h3>
					<div>
						<div>
							<h4>郵便番号</h4>
							<div class="horizontal"><input type="text" class="addressnumber" name="ZipCode1"
							                               maxlength="3" value="<?php echo $resultZipCode1; ?>"
							                               required>
								<p>-</p><input type="text" class="addressnumber" name="ZipCode2" maxlength="4"
								               value="<?php echo $resultZipCode2; ?>" required>
								<input id="button" type="button" value="〒"
								       onclick="AjaxZip3.zip2addr('ZipCode1', 'ZipCode2', 'pref', 'city', 'city');">
							</div>
						</div>
						<div>

							<h4>都道府県</h4>
							<div>
								<select name="pref" required>
									<?php echo preg_replace('/'.$result['Pref'].'\"\>/',
											$result['Pref'].'" selected>', '
									<option value="">都道府県</option>
									<option value="北海道">北海道</option>
									<option value="青森県">青森県</option>
									<option value="秋田県">秋田県</option>
									<option value="岩手県">岩手県</option>
									<option value="山形県">山形県</option>
									<option value="宮城県">宮城県</option>
									<option value="福島県">福島県</option>
									<option value="山梨県">山梨県</option>
									<option value="長野県">長野県</option>
									<option value="新潟県">新潟県</option>
									<option value="富山県">富山県</option>
									<option value="石川県">石川県</option>
									<option value="福井県">福井県</option>
									<option value="茨城県">茨城県</option>
									<option value="栃木県">栃木県</option>
									<option value="群馬県">群馬県</option>
									<option value="埼玉県">埼玉県</option>
									<option value="千葉県">千葉県</option>
									<option value="東京都">東京都</option>
									<option value="神奈川県">神奈川県</option>
									<option value="愛知県">愛知県</option>
									<option value="静岡県">静岡県</option>
									<option value="岐阜県">岐阜県</option>
									<option value="三重県">三重県</option>
									<option value="大阪府">大阪府</option>
									<option value="兵庫県">兵庫県</option>
									<option value="京都府">京都府</option>
									<option value="滋賀県">滋賀県</option>
									<option value="奈良県">奈良県</option>
									<option value="和歌山県">和歌山県</option>
									<option value="岡山県">岡山県</option>
									<option value="広島県">広島県</option>
									<option value="鳥取県">鳥取県</option>
									<option value="島根県">島根県</option>
									<option value="山口県">山口県</option>
									<option value="徳島県">徳島県</option>
									<option value="香川県">香川県</option>
									<option value="愛媛県">愛媛県</option>
									<option value="高知県">高知県</option>
									<option value="福岡県">福岡県</option>
									<option value="佐賀県">佐賀県</option>
									<option value="長崎県">長崎県</option>
									<option value="熊本県">熊本県</option>
									<option value="大分県">大分県</option>
									<option value="宮崎県">宮崎県</option>
									<option value="鹿児島県">鹿児島県</option>
									<option value="沖縄県">沖縄県</option>
								'); ?>
								</select>
							</div>
						</div>
						<div>
							<h4>市区町村</h4>
							<div><input type="text" name="city" value="<?php echo $result['City']; ?>" required>
							</div>
						</div>

						<div>
							<h4>番地</h4>
							<div><input type="text" name="Address" value="<?php echo $result['Address']; ?>" required>
							</div>
						</div>
						<div>
							<h4>建物名など</h4>
							<div><input type="text" name="Apartment" value="<?php echo $result['Apartment']; ?>">
							</div>
						</div>
					</div>
				</div>

				<script>
					$(function () {
						// Ajaxによる重複チェック
						// 電話番号重複チェック
						$('#formPhone').change(function () {
							$.get('php/ajax_checkPhone2.php', {
								Phone: $('#formPhone').val()
							}, function (data) {
								$('#checkPhone').html(data);
							});
						});
						// メールアドレス重複チェック
						$('.formMail').change(function () {
							$.get('php/ajax_checkMail2.php', {
								Mail: $('#formMail1').val() + '@' + $('#formMail2').val()
							}, function (data) {
								$('#checkMail').html(data);
							});
						});
						// パスワードチェック
						$('.formPass').change(function () {
							if ($('#formPass1').val() !== $('#formPass2').val()) {
								$('#checkPass').html('<span style="color:red">パスワードが一致していません。</span>');
							} else {
								$('#checkPass').html('');
							}
						});
					});
				</script>

				<input class="button_c" type="submit" value="送信">
			</div>
		</form>

		<img id="character" alt="O書店公式キャラクター 羽名しおりちゃん" src="img/register_shiori.png">

		<script>
			// ----- Validation Check -----
			// Validation Flag
			$flag = false;
			function reqPhp() {
				$.get('php/ajax_validationCheck2.php', {
					Phone: $('#formPhone').val(),
					Mail: $('#formMail1').val() + '@' + $('#formMail2').val()
				}, function (data) {
					if (data == 'ok') {
						$flag = true;
					} else if (data == 'ng') {
						$flag = false;
					}
				});
			}
			$('#registerForm').submit(function () {
				reqPhp();
				if ($flag && $('#formPass1').val() === $('#formPass2').val()) {
					return true;
				} else {
					return false;
				}
			});
		</script>
	</section>

</div>

<footer>
	<small>Copyright &copy;2016 O書店 All Rights Reserved.</small>
</footer>


</body>

</html>
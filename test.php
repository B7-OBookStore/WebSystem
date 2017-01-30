<?php
/**
 * Created by PhpStorm.
 * User: suzuno
 * Date: 17/01/21
 * Time: 20:37
 */


echo "this is test.<br>";
?>

<?php
require 'php/mailManager.php';
sendMail('ia15076@s.inf.shizuoka.ac.jp','注文完了','test');
/*
require 'php/mailManager.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "kyakuchu.yaro@gmail.com";
$mail->Password = "KuroTaitsu";

$mail->CharSet = "UTF-8";
$mail->Encoding = "base64";

$mail->setFrom('order@kyakuchu-yaro.com', '客注野郎.com');
$mail->addAddress('ia15076@s.inf.shizuoka.ac.jp', 'O書店');

$mail->Subject = '【客注野郎.com】客注注文受付のお知らせ';
$mail->Body = 'test';

$mail->send();

foreach ($mail as $name => $value) {
	echo "$name: $value<br>";
}
*/
?>

<?php
// cls_DuplicateCheck.php テスト用
//
//
//require 'cls_DuplicateCheck.php';
//$hoge = new cls_DuplicateCheck();
//$hoge->existPhone('sana5672@sdnpnbnh.ivx');
?>


<!--// 重複チェックAjax　テスト用-->
<!--<script src="js/jquery-3.1.1.min.js"></script>-->
<!--<form method="POST" action="hogehoge.php">-->
<!--	<input id="formID" type=text name="id">-->
<!--	<input id="submit" value="送信">-->
<!--	<small id="checkID">hogehoge</small>-->
<!--	<script>-->
<!--		$(function () {-->
<!--			// Ajaxによる重複チェック-->
<!---->
<!--			// ID重複チェック-->
<!--			$('input#formID').change(function () {-->
<!--				$.get('res/res_checkID.php', {-->
<!--					UserID: $('#formID').val()-->
<!--				}, function (data) {-->
<!--					$('#checkID').html(data);-->
<!--				});-->
<!--			});-->
<!--		});-->
<!--	</script>-->
<!--</form>-->


<?php
// registration.php -> registration_check.phpの送信チェック
// registration.php のform送信先をtest.phpに変えるとうごきます

//echo $_POST['UserID'].'<br>';
//echo $_POST['Password'].'<br>';
//echo $_POST['Gender'].'<br>';
?>

<?php
// PDOテスト
// 何度か悩んだのでメモ書き兼ねて

//	require ('php/db_connect.php');
//	$st = $pdo->prepare("SELECT UserID, Password FROM User WHERE UserID = :id");
//	$id = 'taki_mitsuha';
//	$st->bindParam(':id', $id,PDO::PARAM_STR);
//	$st->execute();
//	$counter = 0;
//	while ($row = $st->fetch(PDO::FETCH_ASSOC)){
//		echo '<p>'.$row['UserID'].'  '.$row['Password'].'</p>';
//		$counter++;
//	}
//	echo $counter;
?>





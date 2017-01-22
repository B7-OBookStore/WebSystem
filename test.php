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





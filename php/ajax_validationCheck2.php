<?php
/**
 * Verlidation Check用(会員情報変更ページuserdata.php版)。
 * 多少無理矢理な実装ですが…
 * okかngを文字列で値で返しています。
 */

require 'cls_ChangeCheck.php';
$checker = new cls_ChangeCheck();
if(!$checker->existPhone($_GET['Phone']) && !$checker->existMail($_GET['Mail'])) {
	echo 'ok';
} else {
	echo 'ng';
}
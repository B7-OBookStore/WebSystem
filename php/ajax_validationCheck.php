<?php
/**
 * Verlidation Check用。
 * 多少無理矢理な実装ですが…
 * okかngを文字列で値で返しています。
 */

require 'cls_DuplicateCheck.php';
$checker = new cls_DuplicateCheck();
if(!$checker->existPhone($_GET['Phone']) && !$checker->existMail($_GET['Mail'])
		&& !$checker->existUserID($_GET['UserID'])) {
	echo 'ok';
} else {
	echo 'ng';
}
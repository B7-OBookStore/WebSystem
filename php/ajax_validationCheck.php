<?php
/**
 * Verlidation Check用。
 * 多少無理矢理な実装ですが…
 * okかngを文字列で値で返しています。
 */

require 'cls_DuplicateCheck.php';
require 'cls_FormChecker.php';
$checker = new cls_DuplicateCheck();
$formchecker = new cls_FormChecker();
if(!$checker->existPhone($_GET['Phone']) && !$checker->existMail($_GET['Mail'])
		&& !$checker->existUserID($_GET['UserID']) && !$formchecker->phoneChecker($_GET['Phone'])
		&& !$formchecker->mailChecker($_GET['Mail'])) {
	echo 'ok';
} else {
	echo 'ng';
}
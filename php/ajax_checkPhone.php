<?php
require 'cls_DuplicateCheck.php';
require 'cls_FormChecker.php';
$checker = new cls_DuplicateCheck();
$formchecker = new cls_FormChecker();

$msg = '';

// DBチェック
if($checker->existPhone($_GET['Phone'])) {
	$msg = '<span style="color:red">この電話番号はすでに登録されています。</span>';
} else {
	$msg = '<span>この電話番号は使用できます。</span>';
}

// 値のチェック
if($formchecker->phoneChecker($_GET['Phone'])){
	$msg = '';
	$msg = '<span style="color:red">不正な値です。</span>';
}

echo $msg;
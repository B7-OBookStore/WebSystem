<?php
require 'cls_DuplicateCheck.php';
require 'cls_FormChecker.php';
$checker = new cls_DuplicateCheck();
$formchecker = new cls_FormChecker();

$msg = '';

// DBチェック
if($checker->existMail($_GET['Mail'])) {
	$msg = '<span style="color:red">このメールアドレスはすでに登録されています。</span>';
} else {
	$msg = '<span>このメールアドレスは使用できます。</span>';
}

// 値のチェック
if($formchecker->mailChecker($_GET['Mail'])){
	$msg = '';
	$msg = '<span style="color:red">不正な値です。</span>';
}

echo $msg;
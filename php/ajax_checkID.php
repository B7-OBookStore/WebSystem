<?php
require 'cls_DuplicateCheck.php';
require 'cls_FormChecker.php';
$checker = new cls_DuplicateCheck();
$formchecker = new cls_FormChecker();

$msg = '';

// DBチェック
if($checker->existUserID($_GET['UserID'])) {
    $msg = '<span style="color:red">このはすでに登録されています。</span>';
} else {
    $msg = '<span>このIDは使用できます。</span>';
}

// 値のチェック
if($formchecker->IDChecker($_GET['UserID'])){
    $msg = '';
    $msg = '<span style="color:red">不正な値です。</span>';
}

echo $msg;
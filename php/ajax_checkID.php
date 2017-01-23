<?php
require 'cls_DuplicateCheck.php';
$checker = new cls_DuplicateCheck();
if($checker->existUserID($_GET['UserID'])){
	echo '<span style="color:red">このIDはすでに登録されています。</span>';
} else {
	echo '<span>このIDは使用できます。</span>';
}
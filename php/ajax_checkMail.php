<?php
require 'cls_DuplicateCheck.php';
$checker = new cls_DuplicateCheck();
if($checker->existMail($_GET['Mail'])) {
	echo '<span style="color:red">このメールアドレスはすでに登録されています。</span>';
} else {
	echo '<span>このメールアドレスは使用できます。</span>';
}
<?php
require 'cls_ChangeCheck.php';
$checker = new cls_ChangeCheck();
if($checker->existMail($_GET['Mail'])) {
	echo '<span style="color:red">このメールアドレスはすでに登録されています。</span>';
} else {
	echo '<span>このメールアドレスは使用できます。</span>';
}
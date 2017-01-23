<?php
require 'cls_DuplicateCheck.php';
$checker = new cls_DuplicateCheck();
if($checker->existPhone($_GET['Phone'])) {
	echo '<span style="color:red">この電話番号はすでに登録されています。</span>';
} else {
	echo '<span>この電話番号は使用できます。</span>';
}
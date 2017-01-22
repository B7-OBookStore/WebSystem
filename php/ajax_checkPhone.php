<?php
require 'cls_DuplicateCheck.php';
$checker = new cls_DuplicateCheck();
$msg = $checker->existPhone($_GET['Phone']);
echo $msg;
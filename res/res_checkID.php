<?php
require '../cls_DuplicateCheck.php';
$checker = new cls_DuplicateCheck();
$msg = $checker->existUserID($_GET['UserID']);
echo $msg;

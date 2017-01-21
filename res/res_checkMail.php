<?php
require '../cls_DuplicateCheck.php';
$checker = new cls_DuplicateCheck();
$msg = $checker->existMail($_GET['Mail']);
echo $msg;
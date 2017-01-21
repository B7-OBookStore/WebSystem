<?php
/**
 * Created by PhpStorm.
 * User: suzuno
 * Date: 17/01/21
 * Time: 20:37
 */



echo "this is test.<br>";


// cls_DuplicateCheck.php テスト用

require 'cls_DuplicateCheck.php';
$hoge = new cls_DuplicateCheck();
$hoge->existPhone('0961777945');


?>
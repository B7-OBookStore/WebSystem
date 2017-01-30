<?php
/**
 * データベース接続用
 */

/*$dbsrc = 'mysql:host=127.0.0.1; dbname=websysb7; charset=utf8';
$user = 'root';
$pass = 'b7';*/
$dbsrc = 'mysql:host=ja-cdbr-azure-east-a.cloudapp.net; dbname=websysb7; charset=utf8';
$user = 'b3a7f491a4430f';
$pass = '0a1e66e0';
try {
	$pdo = new PDO($dbsrc, $user, $pass);
} catch (PDOException $e) {
	echo $e->getMessage();
}
?>
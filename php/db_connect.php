<?php
/**
 * データベース接続用
 */

$dbsrc = 'mysql:host=127.0.0.1; dbname=websysb7; charset=utf8';
$user = 'root';
$pass = 'b7';
try {
	$pdo = new PDO($dbsrc, $user, $pass);
} catch (PDOException $e) {
	echo $e->getMessage();
}
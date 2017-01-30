<?php
/**
 * デジタルサイネージとの通信用。
 * 一応JSON形式でUnity側に飛ばすように設計してます。
 * でも動くのか？コレ
 */

$reqword = '';
$returnJSON = '';

//if (!isset($_POST['reqword']) || $_POST['reqword'] != 'DigiSignReq') {
//	$redirect = "http://b7-obookstore.azurewebsites.net/404.html";
//	header("HTTP/1.0 404 Not Found");
//	print(file_get_contents($redirect));
//	exit();
//}

require '../php/db_connect.php';

$stmt = $pdo->query("SELECT SUM(StockAmount) AS Amount,BookTitle,GoogleID FROM Stock INNER JOIN Book ON Stock.JANCode = Book.JANCode WHERE GoogleID IS NOT NULL GROUP BY Stock.JANCode ORDER BY AMOUNT DESC LIMIT 40");

$returnJSON = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
print json_encode($returnJSON);

?>
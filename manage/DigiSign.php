<?php
/**
 * デジタルサイネージとの通信用。
 * 一応JSON形式でUnity側に飛ばすように設計してます。
 * でも動くのか？コレ
 */
$reqword = '';
$googleid = '';
$bookArray = array();
$res = array();
//if (!isset($_POST['reqword']) || $_POST['reqword'] != 'DigiSignReq') {
//	$redirect = "http://b7-obookstore.azurewebsites.net/404.html";
//	header("HTTP/1.0 404 Not Found");
//	$res .=(file_get_contents($redirect));
//	exit();
//}
$limit = 40;
require '../php/db_connect.php';
$stmt = $pdo->query("SELECT SUM(StockAmount) AS Amount,BookTitle,GoogleID FROM Stock INNER JOIN Book ON Stock.JANCode = Book.JANCode WHERE GoogleID IS NOT NULL GROUP BY Stock.JANCode ORDER BY AMOUNT DESC LIMIT 40");
// Bookクラスの配列(Limitの数だけ)
require '../php/cls_Book.php';
for($i = 0; $i < 40; $i++){
    $gid = $stmt->fetch(PDO::FETCH_ASSOC);
    $bookArray[$i] = new Book($gid['GoogleID']);
}
// JSON形式の出力
// つらい
for($i = 0; $i < 40; $i++){
    $res[] = array('Title'=>$bookArray[$i]->title,
                        'Author'=>$bookArray[$i]->writer,
                        'Date'=>$bookArray[$i]->publishedDate,
                        'Description'=>$bookArray[$i]->description,
                        'GoogleID'=>$bookArray[$i]->id);
}
header('Content-Type: application/json');
print json_encode($res);
?>
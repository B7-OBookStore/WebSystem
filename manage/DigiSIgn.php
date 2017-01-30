<?php
/**
 * デジタルサイネージとの通信用。
 * 一応JSON形式でUnity側に飛ばすように設計してます。
 * でも動くのか？コレ
 */

$reqword = '';
$googleid = '';
$bookArray = array();
$res = '';

//if (!isset($_POST['reqword']) || $_POST['reqword'] != 'DigiSignReq') {
//	$redirect = "http://b7-obookstore.azurewebsites.net/404.html";
//	header("HTTP/1.0 404 Not Found");
//	$res .=(file_get_contents($redirect));
//	exit();
//}

$limit = 40;
require '../php/db_connect.php';

$stmt = $pdo->query("SELECT SUM(StockAmount) AS Amount, GoogleID FROM Stock INNER JOIN Book ON Stock.JANCode = Book.JANCode WHERE GoogleID IS NOT NULL GROUP BY Stock.JANCode ORDER BY AMOUNT DESC LIMIT $limit");
$googleid = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Bookクラスの配列(Limitの数だけ)
require '../php/cls_Book.php';
for($i = 0; $i < $limit; $i++){
    $bookArray[$i] = new Book($id);
}

// JSON形式の出力
// つらい
$res .= '[';
for($i = 0; $i < $limit; $i++){
    if($i > 0){
        $res .= ',';
    }
    $res .= '{';
    $res .= '"Title":"'.$bookArray[$i]->title.'",';
    $res .= '"Author":"'.$bookArray[$i]->writer.'",';
    $res .= '"Date":"'.$bookArray[$i]->publishedDate.'",';
    $res .= '"Description":"'.$bookArray[$i]->description.'",';
    $res .= '"GoogleID":"'.$bookArray[$i]->id.'"';
    $res .= '}';
}
$res .= ']';

header('Content-Type: application/json');
print json_encode($res);

?>

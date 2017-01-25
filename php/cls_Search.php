<?php

/**
 * 検索に関するクラス。
 */

class cls_Search
{
	/** 特殊な検索ワードが入力された場合の処理 */
	function specialType($q)
	{
		if ($q == NULL) {
			header("Location: index.php");
			exit;
		} else if ($q === '糸田＃') {
			header("Location: img/hosoi.jpg");
			exit;
		} else if ($q === 'unitygame') {
			header("Location: unitygame.php");
			exit;
		}
	}

	/** 書籍の検索 */
	function searchBook($q, $nextIndex){
		$i = 0;
		$q_encoded = urlencode($q);
		$books = array();

		while ($i < 20) {
			$json = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=$q_encoded&startIndex=$nextIndex&maxResults=40&key=AIzaSyBczORlfI6MEmYnkTFwP5au6rq_oo4h92s");
			$results = json_decode($json, TRUE);

			if (count($results[items]) == NULL) {
				break;
			}

			foreach($results[items] as $j => $item) {
				if ($i >= 20) {
					break;
				}

				foreach ($item[volumeInfo][industryIdentifiers] as $k => $identifier) {
					if ($identifier[type] === "ISBN_13") {
						$books[] = $item;
						$i++;
					}
				}
				$nextIndex++;
			}
		}
		return $books;
	}

	/** その他商品の検索 */
	function searchOthers($q, &$pdo){
		// 半角・全角スペースで分割し配列に格納
		$qOther = preg_split('/[\s　]/u', $q);
		for($i = 0; $i < count($qOther); $i++){
			$qOther[$i] = '%'.$qOther[$i].'%';
		}

		// Debug
		// echo var_dump($qOther).'<br>';

		$sqlOther = "SELECT Item.JANCode,Price,Name,Manufacturer,Genre 
                  FROM Item INNER JOIN Other ON Item.JANCode = Other.JANCode 
                  WHERE ";

		// 配列数だけNAME LIKE〜を追加する
		for($i = 0; $i < count($qOther); $i++){
			if($i > 0) $sqlOther .= " AND ";
			$sqlOther .= "Name LIKE :str".$i;
		}

		// プリペアドステートメントを発行し、配列の値を順次バインド
		$others = $pdo->prepare($sqlOther);
		for($i = 0; $i < count($qOther); $i++){
			$others->bindParam(':str'.$i, $qOther[$i], PDO::PARAM_STR);
		}

		$others->execute();
		// Debug
		// echo $sqlOther;
		return $others;
	}
}
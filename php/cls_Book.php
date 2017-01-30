<?php

/*
* 本を現すクラス
*/

class Book {

	public $id;
	public $title;
	public $publishedDate;
	public $description;
	public $publisher;
	public $categories;
	public $isbn10;
	public $janCode;
	public $writer;
	public $imageLinks;
	public $price;

	// コンストラクタ；GoogleIDから本の情報を取得。データベースになければ追加
	function __construct($id) {
		$this->id = $id;
		$json = file_get_contents("https://www.googleapis.com/books/v1/volumes/$id?key=AIzaSyDqDNwOfr_cvL6EeihdleSvHCc9FkmMhE4");
		$results = json_decode($json, TRUE);

		// Googleからタイトル、出版日、説明文、出版社、カテゴリを取得
		$this->title = $results['volumeInfo']['title']." ".$results['volumeInfo']['subtitle'];
		$this->publishedDate = $results['volumeInfo']['publishedDate'];
		$this->description = $results['volumeInfo']['description'];
		$this->publisher = $results['volumeInfo']['publisher'];
		$this->categories = $results['volumeInfo']['categories'];

		// ISBN10とJANコードを取得
		foreach ($results['volumeInfo']['industryIdentifiers'] as $i => $identifier) {
			if ($identifier['type'] === 'ISBN_10') {
				$this->isbn10 = $identifier['identifier'];
			}
			if ($identifier['type'] === 'ISBN_13') {
				$this->janCode = $identifier['identifier'];
			}
		}

		// 筆者を取得、複数人いる場合はカンマで区切る
		foreach($results['volumeInfo']['authors'] as $i => $author) {
			$this->writer = $this->writer.$author.",";
		}
		$this->writer = rtrim($this->writer,',');

		// サムネイルを取得
		$imageNames = array('smallThumbnail','thumbnail','small','medium','large','extraLarge');
		foreach ($imageNames as $i => $imageName) {
			$this->imageLinks[$imageName] = $results['volumeInfo']['imageLinks'][$imageName];

			if ($this->imageLinks[$imageName] == NULL) {
				if ($i == 0) {
					$this->imageLinks[$imageName] = 'img/noimage.png';
				} else {
					$this->imageLinks[$imageName] = $this->imageLinks[$imageNames[$i-1]];
				}
			}
		}

		// DBから価格を取得
		require 'db_connect.php';
		$stmt = $pdo->prepare("SELECT Price FROM Item WHERE JANCode = :jancode");
		$stmt->bindParam(':jancode', $this->janCode, PDO::PARAM_STR);
		$stmt->execute();
		if ($result = $stmt->fetch()) {
			$this->price = $result[Price];
		}

		// DBになかったらGoogleから取得
		if ($this->price == NULL){
			$this->price = $results[saleInfo][price][amount];
		}

		// GoogleBooksにもなかったら国会図書館から取得。かなり無理矢理
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
	
		if ($this->price == NULL) {
			$html = file_get_contents("http://iss.ndl.go.jp/books?ar=4e1f&search_mode=advanced&display=&rft.isbn=$this->janCode");
			$dom = new DOMDocument();
			@$dom->loadHTML($html);
			$as = $dom->getElementsByTagName('a');
	
			foreach ($as as $a) {
				$url = $a->getAttribute('href');
	
				if (preg_match("#^http://iss.ndl.go.jp/books/#",$url)) {
					$html = file_get_contents($url);
					$dom = new DOMDocument();
					@$dom->loadHTML($html);
					$spans = $dom->getElementsByTagName('span');
	
					foreach ($spans as $span){
						$spanValue = $span->nodeValue;
						if (mb_substr($spanValue ,-1) == '円'){
							// 国会図書館のデータは税抜き価格なので1.08かける
							$priceWithoutTax = preg_replace('/[^0-9]/','',$spanValue);
							$this->price = (int)($priceWithoutTax*1.08);
							break;
						}
					}
					break;
				}
			}
		}
		/*
		// JANKEN.JPから取得するスクリプトだが、国会図書館になけりゃここにもあるわけがないので省略
		if ($listPrice == NULL) {
			$html = file_get_contents("http://www.janken.jp/goods/jk_catalog_syosai.php?jan=$janCode");
			$dom = new DOMDocument();
			@$dom->loadHTML($html);
			$tds = $dom->getElementsByTagName('td');
	
			foreach ($tds as $td){
				$tdValue = $td->nodeValue;
				if (mb_substr($tdValue ,0 ,1) == '\\'){
					$listPrice = preg_replace('/[^0-9]/','',$tdValue);
					break;
				}
			}
		}
		*/

		$this->insertDB();
	}

	function insertDB() {
		require 'db_connect.php';

		$stmt = $pdo->prepare("SELECT count(*) FROM Item WHERE JANCode = :jancode");
		$stmt->bindParam(':jancode', $this->janCode, PDO::PARAM_STR);
		$stmt->execute();
		$count = $stmt->fetchColumn();
	
		if ($count == 0) {
			$sql = "INSERT INTO Item(JANCode,Price) VALUES(:JANCode,:Price)";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':JANCode',$this->janCode);
			if ($this->price == NULL) {
				$stmt->bindValue(':Price',NULL,PDO::PARAM_NULL);
			} else {
				$stmt->bindParam(':Price',$this->price);
			}
			$stmt->execute();
	
			$sql = "INSERT INTO Book VALUES(:JANCode,:BookTitle,:Writer,:Publisher,:GoogleID)";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':JANCode',$this->janCode);
			$stmt->bindParam(':BookTitle',$this->title);
			$stmt->bindParam(':Writer',$this->writer);
			$stmt->bindParam(':Publisher',$this->publisher);
			$stmt->bindParam(':GoogleID',$this->id);
			$stmt->execute();
		}
	}
}
?>
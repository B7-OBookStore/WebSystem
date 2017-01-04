<?php
    $q = $_GET["q"];
    $startIndex = $_GET["startIndex"];

    if ($q == NULL){
        header( "Location: index.php" ) ;
	    exit;
    }

    if ($startIndex == NULL) {
        $startIndex = 0;
    }

    $i = 0;
    $books = array();
    
    //while ($i <= 20) {
        $json = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=$q&&startIndex=$startIndex&maxResults=40");
        $results = json_decode($json, TRUE);

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
            $startIndex++;
        }
    //}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="css/search.css">
	<link rel="icon" href="img/favicon.ico">
	<title><?php echo $q ?> -O書店検索</title>
</head>

<body>

    <header>
        <h1><a href="index.php">O書店</a></h1>
		    <span>Web注文機能を使うためには、ログインしてください</span>
		    <a id="login" href="">ログイン</a>
	</header>

    <form id="search" method="get" action="search.php">
			<input name="q" type="search" placeholder="書籍を検索"><!--
            --><input  type="submit" value="">
	</form>

    <div id="main">
        <section id="option">
            (検索オプションとか)
        </section>

        <div id="result">
        <?php
            foreach($books as $i => $book) {
                $id = $book[id];
                $title = $book[volumeInfo][title]." ".$book[volumeInfo][subtitle];
                $publishedDate = $book[volumeInfo][publishedDate];
                $listPrice = $book[saleInfo][listPrice][amount];

                $authors = NULL;
                foreach($book[volumeInfo][authors] as $j => $author) {
                    $authors = $authors.$author."　";
                }

                if ($book[volumeInfo][imageLinks][thumbnail] == NULL) {
                    $thumbnail = "img/noimage.png";
                } else {
                    $thumbnail = $book[volumeInfo][imageLinks][thumbnail];
                }
        ?>
                <section>
                    <a href="<?php echo "detail.php?id=$id" ?>"></a>
                    <img alt="<?php echo $title ?>" src="<?php echo $thumbnail ?>">

                    <div>
                        <h2><?php echo $book[volumeInfo][title] ?></h2>
                        <p class="publishedDate"><?php echo $publishedDate ?></p>

                        <p><?php echo $authors ?></p>

                        <?php if ($listPrice !== NULL) {
                            echo "<p class=\"price\">￥ $listPrice</p>";
                        }?>
                    </div>
                </section>
        <?php
            }
        ?>
        </div>
    </div>

    <footer>
		<a href="">規約</a>
		<a href="">プライバシー</a>
		<a href="">店舗</a>
	</footer>

</body>

</html>
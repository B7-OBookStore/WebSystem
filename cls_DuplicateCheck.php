<?php
/**
 * 会員登録時の重複確認用クラス。
 */

class cls_DuplicateCheck
{

    // 電話番号重複チェック
    function existPhone($phone){
        if($this->dbChecker('Phone',$phone)){
            echo '<p>この電話番号はすでに登録されています。</p>';
        }
    }

    // メールアドレス重複チェック
    function existMail($mail){
        if($this->dbChecker('Mail',$mail)){
            echo '<p>このメールアドレスはすでに登録されています。</p>';
        }
    }

    function existUserID($userid){
        if($this->dbChecker('UserID',$userid)){
            echo '<p>このIDはすでに登録されています。</p>';
        }
    }

    // データベースをチェック
    function dbChecker($checkType, $checkStr){
        // Escape
        $checkStr = htmlspecialchars($checkStr, ENT_QUOTES, 'UTF-8');

        // Load DB
        $dbsrc = 'mysql:dbname=websysb7; charset=utf8';
        $user = 'root';
        $pass = 'b7';
        $pdo = new PDO($dbsrc, $user, $pass);

        // Prepare Statement
        $stmt = $pdo->prepare('SELECT :checktype FROM User');
        $stmt->bindParam(':checktype', $checkType);
        $stmt->execute();

        // Check Duplicate
        foreach($stmt as $row){
            if($row[$checkType] == $checkStr){
                return true;
            }
        }
        return false;
    }
}
?>
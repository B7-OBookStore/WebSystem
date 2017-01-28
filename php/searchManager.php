<?php
/**
 * 検索関係の管理。
 */

require 'cls_Search.php';
$clsSearch = new cls_Search();

// 特殊な検索タイプの指定
$clsSearch->specialType($q);

// ページ数に関する処理 (なんかよくわからなかったのでそのまま)
if ($startIndex == NULL) {
	$startIndex = 0;
}

if ($previousIndex != NULL){
	$previousIndex = explode(",", $previousIndex);
}

$previousIndexNext = $previousIndex;
$previousIndexNext[] = $startIndex;
$nextIndex = $startIndex;


if ($mode == 'book' || $mode == NULL) {
	list($books,$nextIndex) = $clsSearch->searchBook($q, $nextIndex);
} else if ($mode == 'other') {
	$others = $clsSearch->searchOthers($q, $pdo);
}

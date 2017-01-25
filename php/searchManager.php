<?php
/**
 * 検索関係の管理。
 */

$q = $_GET["q"];
$mode = $_GET["mode"];
$startIndex = $_GET["startIndex"];
$previousIndex = $_GET["previousIndex"];

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
	$books = $clsSearch->searchBook($q, $nextIndex);
} else if ($mode == 'other') {
	$others = $clsSearch->searchOthers($q, $pdo);
}
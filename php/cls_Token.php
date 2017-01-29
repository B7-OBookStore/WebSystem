<?php

/**
 * CSRF対策のためのToken発行・チェック用クラス。
 */
class cls_Token
{
	function setToken(){
		session_start();
		$token = rtrim(base64_encode(openssl_random_pseudo_bytes(128)),'=');
		$_SESSION['Token'] = $token;
	}

	/**
	 * セッションのToken変数を照合する。
	 * もし一致しなかった場合falseを返す。
	 */
	function checkToken(){
		session_start();
		if(empty($_SESSION['Token']) || $_SESSION['Token'] != $_POST['Token']){
			return false;
		} else {
			return true;
		}
	}
}
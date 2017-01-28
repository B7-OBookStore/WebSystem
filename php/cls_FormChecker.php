<?php

/**
 * フォームにあり得ない値が存在しているかどうかのチェック
 */
class cls_FormChecker
{
	// 電話番号の値として存在し得ないものが入っているか
	function phoneChecker($Phone){
		return !preg_match('/^\d{10,11}/',$Phone);
	}

	// メールアドレスの値として存在し得ないものが入っているか
	function mailChecker($Mail){
		// RFC準拠。
		// 日本のヘンなキャリアのことは知らん。
		// . を許してしまうと例えばGmailとかユーザ名末尾につければ無限に錬成できてしまうため対応しません。
		return !preg_match('/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/', $Mail);
	}

	// ユーザIDの値として存在し得ないものが入っているかどうか
    function IDChecker($UserID){
	    return !preg_match('/^[a-z0-9]+$/', $UserID);
    }
}
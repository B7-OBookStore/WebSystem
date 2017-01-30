<?php

/**
 * メール送信関連のクラス。
 */

class cls_Mail
{
	private $to = '';
	private $subject = '';
	private $message = '';
	private $headers = 'From: obookstore@b7-obookstore.azurewebsites.net/'."\r\n";

	function __construct($to, $sub, $mes, $hea)
	{
		$this->to = $to;
		$this->subject = $sub;
		$this->message = $mes;
		$this->headers = $hea;

		$this->sendMail();
	}

	/** 情報を元にメールを送信。 */
	function sendMail(){
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");
		mb_send_mail($this->to, $this->subject, $this->message, $this->headers);
	}


}
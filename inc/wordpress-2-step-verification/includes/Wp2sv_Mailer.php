<?php


class Wp2sv_Mailer
{
	function send($result,$to,$subject,$content){
		if($result!==null){
			return $result;
		}
		return wp_mail($to,$subject,$content);
	}
}
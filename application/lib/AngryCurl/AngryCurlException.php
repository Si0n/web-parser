<?php
/**
 * Created by PhpStorm.
 * User: sion
 * Date: 14.10.2017
 * Time: 18:20
 */

namespace application\lib\AngryCurl;
/**
 * AngryCurl custom exception
 */
class AngryCurlException extends Exception
{
	public function __construct($message = "", $code = 0 /*For PHP < 5.3 compatibility omitted: , Exception $previous = null*/)
	{
		AngryCurl::add_debug_msg($message);
		parent::__construct($message, $code);
	}
}
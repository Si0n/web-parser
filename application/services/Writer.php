<?php
/**
 * Created by PhpStorm.
 * User: sion
 * Date: 14.10.2017
 * Time: 19:56
 */

namespace application\services;


interface Writer {
	public static function export($data, $filename);
}
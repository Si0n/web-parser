<?php
/**
 * Created by PhpStorm.
 * User: sion
 * Date: 14.10.2017
 * Time: 19:41
 */

namespace application\services;


class TextWriter implements Writer {

	public static function export($data, $filename) {
		$fh = fopen('php://output', 'w');
		// Start output buffering (to capture stream contents)
		ob_start();


		// CSV Data
		foreach ($data as $row) {
			fwrite($fh, $row . "\r\n");
		}

		// Get the contents of the output buffer
		$string = ob_get_clean();
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='. $filename . '.txt');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		echo $string;
		exit($string);
	}
}
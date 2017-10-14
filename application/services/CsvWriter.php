<?php
/**
 * Created by PhpStorm.
 * User: sion
 * Date: 14.10.2017
 * Time: 19:49
 */

namespace application\services;


class CsvWriter implements Writer {
	public static function export($data, $filename) {
		// No point in creating the export file on the file-system. We'll stream
		// it straight to the browser. Much nicer.

		// Open the output stream
		$fh = fopen('php://output', 'w');

		// Start output buffering (to capture stream contents)
		ob_start();

		// CSV Data
		foreach ($data as $row) {
			if (!is_array($row)) {
				fputcsv($fh, ['url' => $row]);
			}
		}

		// Get the contents of the output buffer
		$string = ob_get_clean();

		// Output CSV-specific headers
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . $filename . '.csv";');
		header('Content-Transfer-Encoding: binary');

		// Stream the CSV data
		exit($string);
	}
}
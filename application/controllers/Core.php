<?php

namespace application\controllers;

use application\services\CsvWriter;
use application\services\TextWriter;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Container;

class Core {
	protected $container;
	protected $view;
	protected $errors = [];

	private $site;
	private $level;
	private $file_name;
	private $file_format;

	public function __construct(Container $container) {
		$this->container = $container;
		$this->view = $container->view;
	}

	public function __invoke(Request $request, Response $response, $args) {
		if ($request->getMethod() == 'GET') {
			$params = $request->getQueryParams();
		} else {
			$params = $request->getParsedBody();
		}
		if ($this->validate($params) && $this->load($params)) {
			if (Parser::load($params)) {
				if ($data = Parser::proceed()) {
					if ($this->file_format == 'txt') {
						return TextWriter::export($data, $this->file_name);
					} elseif ($this->file_format == 'csv') {
						return CsvWriter::export($data, $this->file_name);
					} else {
						echo 'Undefined file format <b>' . PHP_EOL;
						return var_dump($data);
					}
				}
			}
		}
		return $this->view->render($response, 'index.php', [
			'errors' => $this->errors,
			'params' => $params
		]);
	}

	public function load(array $params) {
		$loaded = false;
		foreach ($params as $param => $value) {
			$loaded = true;
			$this->$param = $value;
		}
		return $loaded;
	}

	public function validate($params) {
		if (!empty($params['site']) && !filter_var($params['site'], FILTER_VALIDATE_URL)) {
			$this->errors['site'] = 'Not a valid URL';
		}
		if (!empty($params['file_format']) && !in_array($params['file_format'], ['txt', 'csv'])) {
			$this->errors['file_format'] = 'Not a valid file format';
		}
		if (!empty($params['level']) && (!is_numeric($params['level']) || $params['level'] < 0 || $params['level'] > 999)) {
			$this->errors['level'] = 'Level is not in a valid range 0 - 999';
		}
		return empty($this->errors);
	}
}
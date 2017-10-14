<?php

namespace application\controllers;

use application\lib\AngryCurl\AngryCurl;

class Parser {
	public static $root_url;
	public static $host;
	public static $scheme;
	public static $match = '//a/@href';
	public static $urls = [];
	public static $processedUrls = [];
	public static $not_allowed = [
		'#', '/'
	];
	public static $max_level = 999;
	public static $level = 1;

	public static function proceed() {
		self::addUrlQueue(self::$root_url);
		while (!empty(self::$urls) && self::$level <= self::$max_level) {
			self::getRequest(self::$urls);
			self::$level++;
		}
		if (!empty(self::$urls)) {
			return array_map(function($url) { return $url['url']; }, self::$urls) + self::$processedUrls;
		}
		return self::$processedUrls;
		//return
	}

	public static function getRequest(array $urls) {
		$a = new AngryCurl(function ($response, $info, $request) {
			self::addUrlProcessed($request->url);
			self::removeUrlQueue($request->url);
			$dom = self::getDomDocument($response);
			$xpath = self::getXpath($dom);
			foreach (self::query($xpath, self::$match) as $item) {
				if (self::isAbsoluteUrl($item->value)) {
					if (self::isUrlAllowed($item->value) && !self::isUrlProcessed($item->value) && self::$host == self::getHostUrl($item->value)) {
						self::addUrlQueue($item->value);
					}
				} else {
					if (self::isRelativeUrl($item->value) && self::isUrlAllowed($item->value) && !self::isUrlProcessed(self::$scheme . "://" . self::$host . $item->value)) {
						self::addUrlQueue(self::$scheme . "://" . self::$host . $item->value);
					}
				}
			}
		});
		foreach ($urls as $url) {
			$a->get($url['url']);
		}
		$count_urls = count($urls);
		$window_size = $count_urls == 1 ? 1 : ($count_urls > 50 ? 50 : $count_urls);
		$a->execute($window_size);
	}

	private static function isUrlAllowed($url) {
		return !in_array($url, self::$not_allowed);
	}

	private static function isAbsoluteUrl($url) {
		return filter_var($url, FILTER_VALIDATE_URL);
	}

	private static function isRelativeUrl($url) {
		return strpos($url, '/') === 0 && isset($url[1]) && $url[1] !== '/';
	}

	private static function addUrlProcessed($url) {
		self::$processedUrls[md5($url)] = $url;
	}

	private static function isUrlProcessed($url) {
		return isset(self::$processedUrls[md5($url)]);
	}

	private static function removeUrlQueue($url) {
		unset(self::$urls[md5($url)]);
	}

	private static function addUrlQueue($url) {
		self::$urls[md5($url)] = ['url' => $url, 'level' => self::$level];
	}

	public static function load(array $params) {
		if (!isset($params['site'], $params['level'])) {
			return false;
		}
		if (self::getHostUrl($params['site'])) {
			self::parseRootUrlParameters($params['site']);
			if ($params['level'] > 0) {
				self::$max_level = $params['level'];
			}
			return true;
		} else {
			return false;
		}
	}

	private static function getHostUrl($url) {
		if ($url_parsed = parse_url($url)) {
			if (!empty($url_parsed["host"])) {
				return $url_parsed["host"];
			}
		}
		return false;
	}

	private static function parseRootUrlParameters($url) {
		if ($url_parsed = parse_url($url)) {
			self::$host = $url_parsed['host'];
			self::$scheme = $url_parsed['scheme'];
			self::$root_url = $url;
		}
		return false;
	}

	private static function getDomDocument($html) {
		$dom = new \DOMDocument();
		$internalErrors = libxml_use_internal_errors(true);
		$dom->loadHTML($html);
		libxml_clear_errors($internalErrors);
		return $dom;
	}

	private static function query(\DOMXPath $xpath, $query) {
		$qn = $xpath->query($query);
		if ($qn->length) {
			for ($i = $qn->length; --$i >= 0;) {
				yield $qn->item($i);
			}
		}
	}

	private static function getXpath(\DOMDocument $document) {
		return new \DOMXPath($document);
	}
}
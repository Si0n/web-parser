<?php
$container = $app->getContainer();
$container['view'] = function ($container) {
	return new \Slim\Views\PhpRenderer(DIR_TEMPLATE);
};
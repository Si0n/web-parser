<?php
$app->map(['POST','GET'], '/', \application\controllers\Core::class);
$app->get('/test', function($request, $response) {
	$string = "I should have really done some laundry tonight.";

	$stream = fopen('data://text/plain;base64,' . base64_encode($string),'r');

	echo stream_get_contents($stream);
});
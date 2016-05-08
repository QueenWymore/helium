<?php

require_once __DIR__ . '/../vendor/autoload.php';

$time_start = microtime(true);

$app = new Helium\App();

$app->get('/test/:id/:id2', 'AppController:test');

$app->get('/dupa/:id/:name', function($id, $name){
	echo "hello, $name: " . $id;
});

$app->post('/test/:id', 'AppController:post');

$app->get('/rzal', function(){
	echo 'rzal xD';
});

$app->resource('books');

$app->setDebug(1);

$app->run();

$time_end = microtime(true);

//dividing with 60 will give the execution time in minutes other wise seconds
$execution_time = ($time_end - $time_start);

//execution time of the script
echo '<br><b>Total Execution Time:</b> '.$execution_time.' secs';
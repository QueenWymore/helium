<?php

require_once __DIR__ . '/../vendor/autoload.php';

$time_start = microtime(true);

$app = new Helium\App();

require_once __DIR__ . '/../app/Config/routes.php';

$app->setDebug(1);

$app->run();

$time_end = microtime(true);

$execution_time = ($time_end - $time_start);


echo '<br><b>Total Execution Time:</b> '.$execution_time.' secs';
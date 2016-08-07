<?php

require __DIR__.'/../../vendor/autoload.php';
$a = new \Helium\Exception\HeliumException();
$lithium = new Lithium\Lithium();
$lithium->migrate();
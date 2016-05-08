<?php


class AppController
{
	public function __construct()
	{
		echo 'app controller<br>';
	}

	public function test($param1, $param2)
	{
		echo 'test<br>';
		var_dump($param1);
		var_dump($param2);
	}

	public function post($p1){
		echo $p1;
	}
}
<?php

namespace Helium\Lithium;


class Lithium
{
    public function __construct()
    {
        $config_path = __DIR__ . '../../app/Config/database.json';
        if (!file_exists($config_path)){
            die('Missing database.json file');
        }

        $config = file_get_contents($config_path);
        $config = json_decode($config, true);
        var_dump($config);
    }
}
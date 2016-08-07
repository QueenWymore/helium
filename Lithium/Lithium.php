<?php

namespace Lithium;


class Lithium
{
    public static $conn;
    public function __construct()
    {
    }

    public function migrate()
    {
        $path    = __DIR__ . '/../app/Migrations';
        $files = array_diff(scandir($path), array('.', '..'));
        foreach ($files as $file){
            $file_path = $path . '/' . $file;
            include_once $file_path;
            $class = str_replace('.php', '', $file);
            $migration = new $class();
            if (method_exists($migration, 'up')){
                $migration->up();
            }

        }
    }

    public static function getConn()
    {
        $config_path = __DIR__ . '/../app/Config/database.json';
        if (!file_exists($config_path)){
            die('Missing database.json file');
        }

        $config = file_get_contents($config_path);
        $config = json_decode($config, true);
        return new \PDO('mysql:host='.$config['host'].';dbname='.$config['database'], $config['user'], $config['password']);
    }
}
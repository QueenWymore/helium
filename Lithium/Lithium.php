<?php

namespace Lithium;


class Lithium
{
    private static $conn;

    public function __construct()
    {
    }

    public static function migrate()
    {
        self::createMigrationsTable();
        $path    = __DIR__ . '/../app/Migrations';
        $files = array_diff(scandir($path), array('.', '..'));
        foreach ($files as $file){
            $file_path = $path . '/' . $file;
            include_once $file_path;
            $migrationClass = str_replace('.php', '', $file);
            $migration = new $migrationClass();
            if (method_exists($migration, 'up')){
                $migration->up();
            }

        }
    }

    public static function getConn()
    {
        if (!self::$conn) {
            $config_path = __DIR__ . '/../app/Config/database.json';
            if (!file_exists($config_path)) {
                die('Missing database.json file');
            }

            $config = file_get_contents($config_path);
            $config = json_decode($config, true);
            self::$conn = new \PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['database'], $config['user'], $config['password']);
        }
        return self::$conn;
    }

    public static function info($text)
    {
        print_r($text . "\n");
    }

    private static function createMigrationsTable()
    {
        $migration = new Migration();
        $migration->table('lithium_migrations', function(Table $t) {
           $t
               ->id()
               ->string('name', ['size' => 255]);
        });
    }
}
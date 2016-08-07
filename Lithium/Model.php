<?php


namespace Lithium;


use Helium\Inflect;

class Model
{
    protected static $tableName;

    public function __construct()
    {
        self::$tableName = Inflect::decamelize(Inflect::pluralize(get_class($this)));

    }


    public function save($values)
    {
        $placeholders = array_map(function($v){ return ':'.$v;}, array_keys($values));
        $query = 'INSERT INTO ' . self::$tableName . '('. implode(',', array_keys($values)) .') VALUES ('. implode(',', $placeholders) .')';
        $stmt = Lithium::getConn()->prepare($query);
        foreach ($values as $key => $value){
            $stmt->bindParam(':'.$key, $value);
        }
        $stmt->execute();
        echo $query;
    }
}
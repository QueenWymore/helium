<?php

namespace Lithium;


class Table
{
    const INTEGER = 'INT';
    const STRING = 'VARCHAR';

    protected $name;
    protected $columns;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function integer($name, $size = 6)
    {
        $this->addColumn($name, self::INTEGER, $size);

        return $this;
    }

    public function string($name, $size = 30)
    {
        $this->addColumn($name, self::STRING, $size);
        return $this;
    }

    public function create()
    {
        $query = 'CREATE TABLE ' . $this->name .'(';
        $query .= implode(',', $this->columns);
        $query .= ')';
        Lithium::getConn()->exec($query);
    }

    private function addColumn($name, $type, $size)
    {
        $this->columns[] = "$name $type($size)";
    }
}
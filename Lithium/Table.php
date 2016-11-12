<?php

namespace Lithium;


class Table
{
    const INTEGER = 'INT';
    const STRING = 'VARCHAR';
    const BOOL = 'BOOL';
    const KEY_PRIMARY = 'PRIMARY';
    const KEY_UNIQUE = 'UNIQUE';

    protected $name;
    protected $columns;
    protected $engine;
    protected $primaryKeys = [];
    protected $uniqueKeys = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function integer($name, $options = [])
    {
        $options = $this->getOptions($options);
        $this->addColumn($name, self::INTEGER, $options);

        return $this;
    }

    public function string($name, $options = [])
    {
        $options = $this->getOptions($options);
        $this->addColumn($name, self::STRING, $options);
        return $this;
    }

    public function bool($name, $options = [])
    {
        $options = $this->getOptions($options);
        $this->addColumn($name, self::BOOL, $options);
        return $this;
    }

    public function id($name = 'id')
    {
        $this->addKey(self::KEY_PRIMARY, $name);
        $options = $this->getOptions(['auto_increment' => true]);
        $this->addColumn($name, self::INTEGER, $options);

        return $this;
    }

    public function engine($engine)
    {
        $this->engine = $engine;
    }

    public function create()
    {
        Lithium::info('Creating table '.$this->name);
        $columns = implode(',', $this->columns);
        if (count($this->primaryKeys)) {
            $primaryKeys = ',PRIMARY KEY(`'.implode('`,`', $this->primaryKeys).'`)';
        } else {
            $primaryKeys = '';
        }
        if (count($this->uniqueKeys)) {
            $uniqueKeys = ',UNIQUE KEY ix_'.$this->name.'(`'.implode('`,`', $this->uniqueKeys).'`)';
        } else {
            $uniqueKeys = '';
        }
        if ($this->engine) {
            $engine = ' ENGINE='.$this->engine;
        } else {
            $engine = '';
        }
        $query = "CREATE TABLE IF NOT EXISTS `{$this->name}` ($columns $primaryKeys $uniqueKeys) $engine";
        Lithium::info($query);
        $result = Lithium::getConn()->exec($query);
        if ($result === false) {
            Lithium::info(Lithium::getConn()->errorInfo()[2]);
        }
    }

    private function addColumn($name, $type, $options)
    {
        $column = [];
        $column[] = "`$name` $type";
        if ($options['size']) {
            $column[] = "(" . $options['size'] . ")";
        }
        if (!$options['null']) {
            $column[] = 'NOT NULL';
        }
        if ($options['auto_increment']) {
            $column[] = 'AUTO_INCREMENT';
        }
        if ($options['default'] !== null) {
            $default = $options['default'] === false ? 0 : $options['default'];
            $default = $default === true ? 1 : $default;
            $column[] = 'DEFAULT ' . $default;
        }
        if ($options['key']) {
            $this->addKey($options['key'], $name);
        }

        $this->columns[] = implode(' ', $column);

    }

    private function addKey($key, $name)
    {
        switch (strtoupper($key)) {
            case self::KEY_PRIMARY:
                $this->primaryKeys[] = $name;
                break;
            case self::KEY_UNIQUE:
                $this->uniqueKeys[] = $name;
                break;
        }
    }

    private function getOptions($options)
    {
        return [
            'size' => $this->getOption('size', $options, null),
            'key' => $this->getOption('key', $options, null),
            'null' => $this->getOption('null', $options, true),
            'auto_increment' => $this->getOption('auto_increment', $options, false),
            'default' => $this->getOption('default', $options, null)
        ];
    }

    private function getOption($name, $options, $default)
    {
        if (array_key_exists($name, $options)) {
            $option = $options[$name];
        } else {
            $option = $default;
        }
        return $option;
    }
}
<?php

namespace Lithium;


class Migration
{
    public function __construct()
    {

    }

    public function table($name, $fn)
    {
        $table = new Table($name);
        $fn($table);
        $table->create();
    }
}
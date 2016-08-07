<?php

use Lithium\Table;

class BooksMigration extends Lithium\Migration
{
    public function up()
    {
        $this->table('books', function(Table $t){
            $t->integer('id');
            $t->string('name');
        });
    }
}
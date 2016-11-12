<?php

use Lithium\Table;

class BooksMigration extends Lithium\Migration
{
    public function up()
    {
        $this->table('books', function(Table $t){
            $t
                ->id()
                ->string('name', [
                    'key' => 'unique',
                    'size' => 120
                ])
                ->string('description', [
                    'null' => false,
                    'size' => 255
                ])
                ->integer('rating', [
                    'default' => 0
                ])
                ->bool('available', ['default' => true])
                ->integer('author_id');
        });
    }
}
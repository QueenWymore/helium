<?php

$app->get('/test/:id/:id2', 'AppController:test');

$app->get('/test2/:id/:name', function($id, $name){
    echo "hello, $name: " . $id;
});

$app->post('/test/:id', 'AppController:post');

$app->get('/xd', function(){
    echo 'xD';
});

$app->get('/booksindex', 'BooksController:index', 'test');

$app->resource('books');

$app->resource('posts');

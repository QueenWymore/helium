<?php

$app->get('/test/:id/:id2', 'AppController:test');

$app->get('/dupa/:id/:name', function($id, $name){
    echo "hello, $name: " . $id;
});

$app->post('/test/:id', 'AppController:post');

$app->get('/rzal', function(){
    echo 'rzal xD';
});

$app->get('/hehe', 'BooksController:index', 'test');

$app->resource('books');

$app->resource('posts');

$app->resource('dupa', 'PostsController');
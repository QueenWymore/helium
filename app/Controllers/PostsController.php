<?php

class PostsController extends AppController
{

    public function index()
    {
        echo 'posts index';
        $this->render();
    }
}
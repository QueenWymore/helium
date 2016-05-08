<?php


class BooksController extends AppController
{
    public function index()
    {
        echo 'books index';
    }

    public function show($id)
    {
        echo 'show book ' . $id;
    }

    public function create(){

    }
}
<?php


class BooksController extends AppController
{
    public function index()
    {
        $book = new Book();
        $book->save(['name' => 'O dupie maryni']);
        //$this->setLayout('app.index');
        $this->set('test', 'dupa xD');
        $dupa = 'razdwatrzydupa';
        $rzal = 'heheheheheeh';
        $this->set(compact('dupa', 'rzal'));
        $this->render();
    }

    public function show($id)
    {
        //echo 'show book ' . $id;
        $this->render();
    }

    public function create(){

    }
}
<?php


class BooksController extends AppController
{
    public function index()
    {
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
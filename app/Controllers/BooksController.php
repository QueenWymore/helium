<?php


class BooksController extends AppController
{
    public function index()
    {
        
    }

    public function show($id)
    {
        //echo 'show book ' . $id;
        $this->render();
    }

    public function create(){
        $book = new Book();
        $book->save(['name' => 'BleBleble']);
        //$this->setLayout('app.index');
        $this->set('test', 'xd');
        $test1 = 'razdwatrzy';
        $test2 = 'heheheheheeh';
        $this->set(compact('test1', 'test2'));
        $this->render();
    }
}

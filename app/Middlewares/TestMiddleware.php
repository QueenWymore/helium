<?php

class TestMiddleware
{
    public function before()
    {
        echo 'before';
        return false;
    }

    public function after()
    {
        echo 'after';
    }
}
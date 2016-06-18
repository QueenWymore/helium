<?php

namespace Helium;


class Controller
{

    private $layout;

    private $vars = [];

    public function __construct()
    {
        $this->layout = 'app.index';
    }

    public final function setLayout($layout){
        $this->layout = $layout;
    }

    public final function render($resource = null, $action = null)
    {
        if (!$resource) {
            $class = get_class($this);
            if (strpos(strtolower($class), 'controller') !== false) {
                $resource = ucfirst(preg_replace('/controller/i', '', $class));
            } else {
                $resource = $class;
            }
        }
        if (!$action) {
            $action = debug_backtrace()[1]['function'];
        }

        $renderer = new Renderer($resource, $action);
        $renderer->setVars($this->vars);
        $renderer->setLayout($this->layout);
        $renderer->render();
    }

    public final function set($arg1, $arg2 = null){
        if ($arg1 && $arg2){
            $this->vars[$arg1] = $arg2;
        } elseif (is_array($arg1)) {
            foreach ($arg1 as $k => $v){
                $this->vars[$k] = $v;
            }
        }
    }

}
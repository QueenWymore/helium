<?php

namespace Helium;


class Renderer
{
    protected $resource;
    protected $action;
    protected $layout;
    protected $exports = [];
    protected  $vars = [];

    public function __construct($resource = null, $action = null)
    {
        $this->resource = $resource;
        $this->action = $action;
        $this->layout = 'app.index';
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function setVars($vars)
    {
        $this->vars = $vars;
    }

    public function render()
    {
        ob_start();

        foreach ($this->vars as $name => $var){
            $$name = $var;
        }

        $path = $this->getViewPath($this->layout);

        require_once $path;

        $content = ob_get_contents();
        ob_end_clean();

        $content = $this->replaceExports($content);
        echo $content;
    }

    public function element($name)
    {
        $path = $this->getViewPath($name);
        if (file_exists($path)) {
            require_once $path;
        }
    }

    public function renderContent()
    {
        $path = $this->getViewPath([$this->resource, $this->action]);
        if (file_exists($path)) {

            foreach ($this->vars as $name => $var){
                $$name = $var;
            }

            require_once $path;
        } else {
            throw new Exception\MissingFileException($path);
        }
    }

    public function style($name, $export = false)
    {
        $path = $this->getStylePath($name);
        $styleString = '<link rel="stylesheet" href="' . $path . '">';
        if ($export) {
            return $styleString;
        } else {
            echo $styleString;
        }
    }

    public function import($name)
    {
        $hash = $this->createExportHash($name);
        echo $hash;
    }

    public function export($name, $value)
    {
        $hash = $this->createExportHash($name);
        $this->exports[$hash] = $value;
    }

    private function createExportHash($name)
    {
        return '=export' . md5($name);
    }

    private function getStylePath($name)
    {
        return $this->getPath($name, 'Assets/css', 'css');
    }
    private function getViewPath($name)
    {
        return $this->getPath($name, 'app/Views', 'php');
    }

    private function getPath($name, $directory, $ext)
    {
        if (is_array($name)){
            $elements = $name;
        } else {
            $elements = explode('.', $name);
        }
        $file = array_pop($elements);
        $dirs = $elements;
        $path = '../'.$directory;
        foreach ($dirs as $dir){
            $path .= '/'.ucfirst($dir);
        }
        $path .= '/'.strtolower($file).'.'.$ext;
        return $path;
    }

    private function replaceExports($content)
    {
        foreach ($this->exports as $hash => $export){
            if (strpos($content, $hash) !== false){
                $content = str_replace($hash, $this->exports[$hash], $content);
            }
        }
        return $content;
    }
}
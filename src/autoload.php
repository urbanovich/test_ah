<?php

namespace TestAH;

class autoload
{
    public function load($class)
    {
        $namespace = 'TestAH';
        if (strpos($class, $namespace) !== false) {
            $class = str_replace('\\', '/', $class);
            $class = str_replace($namespace, __DIR__, $class);
            $file = $class . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }
    public static function register()
    {
        spl_autoload_register(array(new autoload(), 'load'));
    }
}

autoload::register();
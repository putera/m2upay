<?php

spl_autoload_register(function ($class)
{
    if (substr($class, 0, 4) !== 'M2U\\') {
        return;
    }

    $class = str_replace('\\', '/', $class);
    $path = dirname(__FILE__).'/'.$class.'.php';
    if (is_readable($path)) {
        require_once $path;
        return;
    }
});
<?php

function autoload($class)
{
    $baseDirectory = DIR_APP . DS;
    $class = $baseDirectory . DS . str_replace('\\', DS, $class) . '.php';

    if (file_exists($class) && !is_dir($class)) {
        include $class;
    }
}

spl_autoload_register('autoload');
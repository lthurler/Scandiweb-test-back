<?php

function autoload($class)
{
    $baseDirectory = DIR_APP . DS;
    $class = $baseDirectory . DS . str_replace('\\', DS, $class) . '.php';
    // var_dump($class);exit;
    
    if (file_exists($class) && !is_dir($class)) {
        include $class;
    }
}

spl_autoload_register('autoload');

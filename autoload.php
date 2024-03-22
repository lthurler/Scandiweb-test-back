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

// spl_autoload_register(function ($class) {
//     // Namespace raiz da sua aplicação
//     $rootNamespace = DIR_PROJECT;

//     // Diretório raiz da sua aplicação
//     $rootDirectory = DIR_APP . DIRECTORY_SEPARATOR;

//     // Remove o namespace raiz do nome da classe
//     $classWithoutRootNamespace = str_replace($rootNamespace, '', $class);

//     // Transforma o namespace da classe em um caminho de diretório
//     $classFilePath = str_replace('\\', DIRECTORY_SEPARATOR, $classWithoutRootNamespace);

//     // Caminho completo do arquivo da classe
//     $classFile = $rootDirectory . $classFilePath . '.php';

//     // Verifica se o arquivo da classe existe e o inclui se existir
//     if (file_exists($classFile) && !is_dir($classFile)) {
//         include $classFile;
//     }
// });









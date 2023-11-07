<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);
define('DIR_PROJECT', 'scandweb-back');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_ENV = parse_ini_file(DIR_APP . DS . '.env');


if (file_exists('autoload.php')) {
    include 'autoload.php';

} else {
    echo 'Error adding bootstrap';
    exit;
}
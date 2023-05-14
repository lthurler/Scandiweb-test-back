<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('PORT', '3306');
define('DB', 'scandiweb_test');
define('DRIVE', "mysql");

define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);
define('DIR_PROJECT', 'scandiweb_test');

// define("TOKEN", "f5431a49-60c3-4eef-997a-39b1c71e31bd");

if (file_exists( filename: 'autoload.php')) {
    include 'autoload.php';

} else {
    echo 'Error adding bootstrap';exit;
}

<?php

namespace Service;

use PDO;

class DAO
{
    private $pdo;

    function connect()
    {
        try {            
            $pdo = new PDO(DRIVE . ":host=" . HOST . ";port=" . PORT . ";dbname=" . DB, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            $pdo = null;
            echo ("<b>PDO Error:</b> " . $e->getMessage() . "</br>");
        }
        return $pdo;
    }
}

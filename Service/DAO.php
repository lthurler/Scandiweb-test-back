<?php

namespace Service;

use PDO;
use PDOException;

class DAO
{
     private $pdo;

    public function connect()
    {
        try {
            $pdo = new PDO("mysql:host=" . $_ENV['HOST'] . ";dbname=" . $_ENV['DB'], $_ENV['USER'], $_ENV['PASS']);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            $pdo = null;
            echo ("<b>PDO Error:</b> " . $e->getMessage() . "</br>");
        }
        return $pdo;
    }

    public function close() {
        if ($this->pdo !== null) {
          $this->pdo = null;
        }
      }
}
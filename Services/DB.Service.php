<?php

namespace Archery\Services;

use PDO;
use PDOException;

class DB extends PDO
{
    protected static $instance;

    public function __construct()
    {
        try {
            parent::__construct("mysql:host=localhost;dbname=ass", "root", "root");
        } catch (PDOException $Exception) {
            header('location: /error');
        }
    }


    public function query($statement, $mode = PDO::ATTR_DEFAULT_FETCH_MODE, $arg3 = null)
    {
        parent::query($statement);
    }


    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

}


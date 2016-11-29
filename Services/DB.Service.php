<?php

namespace Archery\Services;

use PDO;
use PDOException;
use Archery\Services\Evn;

class DB extends PDO
{
    protected static $instance;

    public function __construct()
    {
        try {
            $env = new Env();
            parent::__construct($env->database, $env->username, $env->password);
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


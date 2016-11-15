<?php

namespace Archery\Models;

use Archery\Exceptions\CustomException;
use Archery\Services\Database;


/**
 * Abstract Class Base
 *
 * Creates a database connection each time a derrived instances is called.
 *
 * @package
 */
abstract class Base
{
    protected $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

}

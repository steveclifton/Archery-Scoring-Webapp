<?php

namespace Archery\Models;

use Archery\Services\DB;


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
        $this->database = DB::getInstance();
    }

}

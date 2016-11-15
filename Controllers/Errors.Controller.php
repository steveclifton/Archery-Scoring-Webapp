<?php


namespace Archery\Controllers;

/**
 * Class Errors
 * @package
 */
class Errors extends Base
{

    /**
     * If a page does not exist, render the 404 view
     */
    public function notFound()
    {

        $this->render('Page Not Found', '404.view');
    }
}


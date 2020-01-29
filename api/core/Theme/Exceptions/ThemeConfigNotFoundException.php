<?php

namespace Core\Theme\Exceptions;

use Exception;

class ThemeConfigNotFoundException extends Exception
{
    /**
     * ThemeConfigNotFoundException constructor.
     * @param $path
     */
    public function __construct($path)
    {
        parent::__construct("The configuration file '$path' has not found! Ensure the config.json file exists in the directory.");
    }
}

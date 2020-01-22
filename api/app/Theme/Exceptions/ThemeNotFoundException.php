<?php

namespace App\Theme\Exceptions;

use Exception;

class ThemeNotFoundException extends Exception
{
    /**
     * ThemeNotFoundException constructor.
     * @param $themeName
     */
    public function __construct($themeName)
    {
        parent::__construct("Theme '$themeName' was not found!");
    }
}

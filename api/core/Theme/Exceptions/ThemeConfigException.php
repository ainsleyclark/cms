<?php

namespace Core\Theme\Exceptions;

use Exception;

class ThemeConfigException extends Exception
{
    /**
     * ThemeConfigException constructor.
     *
     * @param $message
     * @param $theme
     */
    public function __construct($message, $theme)
    {
        parent::__construct("There is an error in the $theme configuration file. $message ");
    }
}

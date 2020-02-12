<?php

namespace Core\Theme\Exceptions;

use Exception;

class ThemeConfigException extends Exception
{
    /**
     * ThemeConfigException constructor.
     *
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}

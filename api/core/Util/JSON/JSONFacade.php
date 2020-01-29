<?php

namespace Core\Util\JSON;

use Illuminate\Support\Facades\Facade;

class JSONFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'json';
    }

}

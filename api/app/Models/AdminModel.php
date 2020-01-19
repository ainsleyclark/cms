<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{

    /**
     *
     */
    public function setTheme($theme)
    {
        if (!$theme) {
            return false;
        }

        $info = $this->getThemeConfig($theme)->theme;

        //Insert config to DB
        dd($info);

    }


}

<?php

namespace Core\Settings;

use Illuminate\Support\Facades\DB;

class Settings
{
    /**
     * Updates or inserts a new setting.
     *
     * @param $name
     * @param $value
     * @return bool
     */
    public function store($name, $value) {

        $updateOrInsert = DB::table('settings')->where('name', $name)->count() > 0;

        if ($updateOrInsert) {

            if (DB::table('settings')->where('name',  $name)->update(['value' => $value])) {
                return true;
            }

            return false;

        } else {

            $insert = [
                'name' => $name,
                'value' => $value
            ];

            if (DB::table('settings')->insert($insert)) {
                return true;
            }

            return false;
        }
    }
}
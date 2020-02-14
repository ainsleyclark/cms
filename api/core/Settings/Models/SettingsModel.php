<?php

namespace Core\Settings\Models;

use Illuminate\Support\Facades\DB;

class SettingsModel
{
    /**
     * Updates or inserts a new setting.
     *
     * @param $name
     * @param $value
     * @return bool
     */
    public function store($name, $value)
    {
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

    /**
     * Get setting by name.
     *
     * @param $name
     * @return bool|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getByName($name)
    {
        $query = DB::table('settings')
            ->where('name', $name)
            ->first();

        if (!$query) {
            return false;
        }

        return $query;
    }

    /**
     * Get setting by value.
     *
     * @param $name
     * @return bool|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getByValue($value)
    {
        $query = DB::table('settings')
            ->where('value', $value)
            ->first();

        if (!$query) {
            return false;
        }

        return $query;
    }

    /**
     * Get a setting value by its name.
     *
     * @param $name
     * @return bool|mixed
     */
    public function getValueByName($name)
    {
        $query = DB::table('settings')
            ->where('name', $name)
            ->value('value');

        if (!$query) {
            return false;
        }

        return $query;
    }
}

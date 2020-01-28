<?php

namespace App\Core\Util\JSON;

class JSONValidator {

    /**
     * @param $array
     */
    public static function validate($json)
    {

        $arr = json_decode($json, true);

        dd($arr);

        $Mfr = array_column($arr, 1);
        $dupes = array_diff(array_count_values($Mfr), [1]);
        $res = [];

        foreach($dupes as $key => $val){
            $res[$key] = max(array_intersect_key(array_column($arr, 2), array_intersect($Mfr, [$key])));
        }

        dd($dupes);



        //dd(count(array_flip(array_column($data, 'number'))) != count($data));
    }

    private function checkDuplicates($array)
    {

    }
}
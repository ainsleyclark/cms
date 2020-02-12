<?php

namespace Core\Util;

/**
 * Class JSON
 *
 * @package Core\Util
 */
class JSON {

    /**
     * Validate JSON
     *
     * @param $path
     * @return mixed
     */
    public static function validate($path)
    {
        return self::checkJSON(self::checkFile($path));
    }

    /**
     * Checks if the file exists.
     *
     * @param $path
     * @return false|string
     */
    private static function checkFile($path)
    {
       try {
           return file_get_contents($path);
       } catch (\Exception $e) {
           return false;
       }
    }

    /**
     * Checks if JSON file is valid.
     *
     * @param $json
     * @return mixed
     */
    private static function checkJSON($json)
    {
        $json = json_decode($json);

        if (!isset($json)) {
            return false;
        }

        return $json;
    }
}

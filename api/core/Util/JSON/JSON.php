<?php

namespace Core\Util\JSON;

use Core\Theme\Exceptions\ThemeConfigException;
use Core\Theme\Exceptions\ThemeConfigNotFoundException;

class JSON {

    /**
     * Validate JSON
     *
     * @param $path
     * @param null $theme
     * @return mixed
     * @throws ThemeConfigException
     * @throws ThemeConfigNotFoundException
     */
    public function validate($path, $theme)
    {
        return $this->checkJSON($this->checkFile($path), $theme);
    }

    /**
     * Checks if the file exists.
     *
     * @param $path
     * @return false|string
     * @throws ThemeConfigNotFoundException
     */
    private function checkFile($path)
    {
       try {
           return file_get_contents($path);
       } catch (\Exception $e) {
           throw new ThemeConfigNotFoundException($path);
       }
    }

    /**
     * Checks if JSON file is valid.
     *
     * @param $json
     * @param $theme
     * @return mixed
     * @throws ThemeConfigException
     */
    private function checkJSON($json, $theme)
    {
        $json = json_decode($json);

        if (!isset($json)) {
            throw new ThemeConfigException($json, $theme);
        }

        return $json;
    }
}

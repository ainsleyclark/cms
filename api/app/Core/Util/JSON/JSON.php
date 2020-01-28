<?php

namespace App\Core\Util\JSON;

class JSON {

    /**
     * @var
     */
    protected $json;

    /**
     * Validates JSON File
     *
     * @param $json
     */
    public function validate($path)
    {
        dd($this->mime($path));

        $file = file_get_contents($path);


//        $json = json_decode($file);
//
//        $this->json = $json;



    }

    /**
     * Checks if JSON Exists.
     *
     * @param $json
     * @return bool
     */
    private function exists($json)
    {
        return !isset($json) ? false : true;
    }

    private function mime($path)
    {
        dd(mime_content_type($path));


    }

    /**
     * @param $json
     */
    private function valid($json)
    {


    }
}

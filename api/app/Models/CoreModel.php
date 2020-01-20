<?php

namespace App\Models;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;

class CoreModel extends Model
{
    /**
     * Get the sites configuration file.
     *
     * @return mixed
     * @throws FileNotFoundException
     */
    public function getSiteConfig()
    {
        $configPath = root_path() . '/config.json';

        if (file_exists($configPath)) {
            return json_decode(file_get_contents($configPath));
        } else {
            throw new FileNotFoundException('The config.json file was not found in the root directory. Path:' . $configPath);
        }
    }





}

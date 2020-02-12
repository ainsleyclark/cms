<?php

namespace Core\System;

use Core\Support\Facades\Theme;
use Illuminate\Support\Facades\File;

/**
 * Class Assets
 *
 * @package Core\System\Paths
 */
class Assets
{
    /**
     * Get asset url and return response based on file type
     *
     * @param $asset
     * @return mixed
     */
    public static function resolve($asset)
    {
        $path = Theme::getPath() . '/' . Theme::getAssetsPath()[0] . '/';
        $path =  $path . $asset;
        $file = file_get_contents($path);

        if (!$file) {
            return false;
        }

        return [
            'file' => $file,
            'contentType' => File::mimeType($path),
        ];
    }
}
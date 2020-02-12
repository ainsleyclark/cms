<?php

namespace Core\Util;

/**
 * Class Slugify
 *
 * @package Core\Util
 */
class Slugify {

    /**
     * Slugifies given input
     *
     * @param $text
     * @return bool|false|string|string[]|null
     */
    public static function process($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
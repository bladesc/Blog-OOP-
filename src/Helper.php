<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 08.09.2018
 * Time: 00:47
 */

namespace Blog;

class Helper
{
    /**
     * It return trim text to length passed in method
     *
     * @param string $text
     * @param int $characters
     * @return string
     */
    public static function trimText(string $text, int $characters): string
    {
        return substr($text, 0, $characters) . " ...";
    }

    public static function dateOutput($date, $typeOutput = null)
    {
        if (isset($date)) {
            return date_format(date_create($date), 'Y-m-d');
        } else {
            return $date;
        }

    }
}
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
     * It returns trim text to length passed in method
     *
     * @param string $text
     * @param int $characters
     * @return string
     */
    public static function trimText(string $text, int $characters): string
    {
        return (isset($text)) ? substr($text, 0, $characters) . " ..." : "";
    }

    /**
     * it returns date with its changed format
     *
     * @param $date
     * @param null $typeFormat
     * @return false|string
     */
    public static function changeDateFormat($date, $typeFormat = null)
    {
        if (isset($date)) {
            return date_format(date_create($date), 'Y-m-d');
        } else {
            return $date;
        }
    }

    public static function createLink()
    {
    }

    public static function showNowDate()
    {
        return date("Y-m-d H:i:s");
    }
}
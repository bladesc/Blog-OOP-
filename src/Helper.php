<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 03:32
 */

namespace Blog;

class Helper
{
    public static function validateEmail($email)
    {
        $pattern = '/^([a-zA-Z]|-|_)+@[a-zA-Z]+\.[a-zA-Z]+$/';
        if (preg_match($pattern, $email)) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateValue($value)
    {
        return htmlspecialchars(trim($value));
    }
}
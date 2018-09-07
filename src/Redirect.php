<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 21:33
 */
declare(strict_types=1);

namespace Blog;


class Redirect
{

    public static function redirectBack($value = null, Session $session = null)
    {
        if (isset($value)) {
            $session->setSession('messages', $value);
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public static function redirectTo($to, $value = null,  Session $session = null)
    {
        if (isset($value)) {
            $session->setSession('messages', $value);
        }
        header('Location: ' . $to);
    }
}
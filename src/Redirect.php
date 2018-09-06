<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 21:33
 */

namespace Blog;


class Redirect
{

    public function redirectBack($value = null, Session $session = null)
    {
        if (isset($value)) {
            $session->setSession('messages', $value);
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function redirectTo($value = null)
    {

    }
}
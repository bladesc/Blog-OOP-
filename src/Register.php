<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 03:03
 */

namespace Blog;


class Register
{
    private $db;
    private $user;
    private $session;

    public function __construct(Db $db, User $user, Session $session)
    {
        $this->db = $db;
        $this->user = $user;
        $this->session = $session;
    }

    public function register()
    {

    }

}
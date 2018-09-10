<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 10.09.2018
 * Time: 22:36
 */

namespace Blog;


class Remind
{
    private $db;
    private $user;
    private $session;

    public function __construct(Db $db, User $user, Session $session)
    {
        $this->db = $db;
        $this->session = $session;
        $this->user = $user;
    }

    public function remind()
    {
        
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 02.09.2018
 * Time: 22:04
 */
namespace Blog;

class Db
{
    private $dbConnection;

    private $dbHost = 'localhost';
    private $dbLogin = 'root';
    private $dbPassword = '';
    private $dbName = 'blogoop';

    public function __construct()
    {
        try {
            $this->dbConnection = new \PDO('mysql:host='.$this->dbHost.';dbname='.$this->dbName, $this->dbLogin, $this->dbPassword);
        } catch (\PDOException $e) {
            return 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
        }
    }

}

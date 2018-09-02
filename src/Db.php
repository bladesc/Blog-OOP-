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
            $this->dbConnection = new \PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbLogin, $this->dbPassword);
            $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            return 'Connection failed: ' . $e->getMessage();
        }
    }

    public function selectData(string $what = '*', string $from = '', array $where = [], $limit = false, array $orderBy = [])
    {
        $query = "SELECT $what";
        $query .= " FROM $from";

        if (!empty($where)) {
            $query .= " WHERE $where[0] $where[1] $where[2]";
        }
        if ($limit) {
            $query .= " LIMIT $limit";
        }
        if (!empty($orderBy)) {
            $query .= " ORDER BY {$orderBy[0]} {$orderBy[1]}";
        }
        //echo $query; die;
        $selectQuery = $this->dbConnection->prepare($query);
        try {
            $selectQuery->execute();
        } catch (\PDOException $e) {
            return 'Query failed: ' . $e->getMessage();
        }

        $result = $selectQuery->fetch();

        if ($selectQuery->rowCount() > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function closeConnection()
    {
    }

    public function lastInsertId(): int
    {
        return $this->dbConnection->lastInsertId();
    }


}

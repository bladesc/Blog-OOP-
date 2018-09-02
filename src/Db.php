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
    private $stmt;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
        $options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbConnection = new \PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbLogin, $this->dbPassword, $options);
            $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->dbConnection = new \PDO($dsn, $this->dbLogin, $this->dbPassword);
        } catch (\PDOException $e) {
            return 'Connection failed: ' . $e->getMessage();
        }
    }


    public function prepare(string $query): void
    {
        $this->stmt = $this->dbConnection->prepare($query);
    }

    public function execute(): void
    {
        $this->stmt->execute();
    }

    public function getRecords()
    {
        return $this->stmt->fetch();
    }

    public function getRowCount(): int
    {
        return $this->stmt->rowCount();
    }

    public function beginTransaction()
    {
        return $this->stmt->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->stmt->commit();
    }

    public function cancelTransaction()
    {
        return $this->stmt->rollBack();
    }

    /*public function selectData(string $what = '*', string $from = '', array $where = [], $limit = false, array $orderBy = [])
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
            return 'No data found';
        }
    }*/

    public function closeConnection()
    {
        $this->dbConnection = null;
    }

    public function lastInsertId(): int
    {
        return $this->dbConnection->lastInsertId();
    }


}

<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 02.09.2018
 * Time: 22:04
 */

declare(strict_types=1);

namespace Blog;

include(__DIR__ . '/../config/config.php');

class Db
{
    private $dbConnection;

    private $dbHost = DB_HOST;
    private $dbLogin = DB_LOGIN;
    private $dbPassword = DB_PASSWORD;
    private $dbName = DB_NAME;
    private $stmt;

    private $errorMessages = [];

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;

        try {
            $this->dbConnection = new \PDO($dsn, $this->dbLogin, $this->dbPassword);
            $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $this->addMessage('Connection failed: ' . $e->getMessage());
        }
    }

    public function prepare(string $query): void
    {
        try {
            $this->stmt = $this->dbConnection->prepare($query);
        } catch (\PDOException $e) {
            $this->addMessage('Prepare failed: ' . $e->getMessage());
        }
    }

    public function execute()
    {
        try {
            return $this->stmt->execute();
        } catch (\PDOException $e) {
            $this->addMessage('Connection failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getRecords(): array
    {
        return $this->stmt->fetchAll();
    }

    public function getRecord(): array
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


    public function closeConnection()
    {
        $this->dbConnection = null;
    }

    public function lastInsertId()
    {
        return $this->dbConnection->lastInsertId();
    }

    /**
     * It adds messages to array
     *
     * @param string $message
     */
    public function addMessage(string $message): void
    {
        $this->errorMessages[] = $message;
    }

    /**
     * It shows messages
     *
     * @return array
     */
    public function showMessage(): array
    {
        return $this->errorMessages;
    }

}

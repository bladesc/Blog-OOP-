<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 03.09.2018
 * Time: 01:15
 */

declare(strict_types=1);

namespace Blog;

class Entry
{
    private $db;

    private $errorMessages = [];

    private $textMessages = [
        "Deleted successful",
        "Deleted error"
    ];

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function getEntries()
    {
        $this->db->prepare('select * from entries');
        if ($this->db->execute()) {
            return $this->db->getRecords();
        }

    }

    public function getEntry(int $id): array
    {
        $this->db->prepare("select * from entries where id = $id");
        if ($this->db->execute()) {
            return $this->db->getRecord();
        }
    }

    public function addEntry(Category $category)
    {

    }

    public function deleteEntry(int $id)
    {
        $this->db->prepare("DELETE FROM entries where id = $id");
        if ($this->db->execute()) {
            $this->addMessage($this->textMessages[0]);
        } else {
            $this->addMessage($this->textMessages[1]);
        }
    }

    public function modifyEntry(int $id)
    {
    }

    public function addMessage(string $message): void
    {
        $this->errorMessages[] = $message;
    }

    public function showMessage(): array
    {
        return $this->errorMessages;
    }
}
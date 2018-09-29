<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 20:33
 */

declare(strict_types=1);

namespace Blog;

class Category
{
    private $id;
    private $name;
    private $enabled;

    private $db;

    private $errorMessages = [];

    private $textMessages = [
        "Deleted successful",
        "Deleted error"
    ];

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function create()
    {
        $this->db->prepare("
        INSERT INTO categories (name, enabled)
        VALUES
        (
        '$this->name',
        '$this->enabled'
        )
        ");

        return $this->db->execute();
    }

    public function getAllWidthEntries($enable = true)
    {
        if ($enable) {
            $this->db->prepare(
                'SELECT categories.*,(
                          SELECT count(*) FROM entries where categories.id = entries.id_category
                          ) as entries
                      FROM categories');
        }

        if ($this->db->execute()) {
            return $this->db->getRecords();
        } else {
            return false;
        }
    }

    public function getAll()
    {
        $this->db->prepare(
            'SELECT * FROM categories');

        if ($this->db->execute()) {
            return $this->db->getRecords();
        } else {
            return false;
        }
    }

    public function delete(int $id)
    {
        $this->db->prepare("DELETE FROM categories where id = $id");
        if ($this->db->execute()) {
            $this->addMessage($this->textMessages[0]);
        } else {
            $this->addMessage($this->textMessages[1]);
        }
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
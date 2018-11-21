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
    /**
     * @var
     */
    private $id;
    private $name;
    private $enabled;

    private $db;

    private $errorMessages = [];

    private $textMessages = [
        "Deleted successful",
        "Deleted error"
    ];

    /**
     * Category constructor.
     *
     * @param DB $db
     */
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * It sets name for category
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * It sets on/off for category
     *
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * It sets id for category
     *
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * It creates category
     *
     * @return bool
     */
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

    /**
     * It updates category by id
     *
     * @return bool
     */
    public function update()
    {
        $this->db->prepare("
        UPDATE categories SET 
        name = '$this->name',
        enabled = '$this->enabled'
        WHERE id = $this->id;
        ");

        return $this->db->execute();
    }

    /**
     * It returns amount of entries in passed category
     *
     * @param bool $enable
     * @return array|bool
     */
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

    /**
     * It returns all data from categories table
     *
     * @return array|bool
     */
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

    /**
     * It deletes data by id
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->db->prepare("DELETE FROM categories where id = $id");
        if (!$this->db->execute()) {
            $this->addMessage($this->textMessages[1]);
        }
    }

    /**
     * It return data by id
     *
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        $this->db->prepare("SELECT * FROM categories WHERE id = $id");
        if ($this->db->execute()) {
            return $this->db->getRecord();
        }
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
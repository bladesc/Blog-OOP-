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
    private $id;
    private $title;
    private $description;
    private $categoryId;
    private $dateCreatedAt;
    private $dateModifiedAt;

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

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCategoryId(string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function setDateCreatedAt(string $dateCreatedAt): void
    {
        $this->dateCreatedAt = $dateCreatedAt;
    }

    public function setDateUpdatedAt(string $dateModifiedAt): void
    {
        $this->dateModifiedAt = $dateModifiedAt;
    }

    public function update()
    {
        $this->db->prepare("
        UPDATE `entries` SET 
        `title` = '$this->title',
         `description` = '$this->description',
         `created_at` = '$this->dateCreatedAt',
         `modified_at` = '$this->dateModifiedAt',
         `id_category` = '$this->categoryId'
        WHERE `entries`.`id` = $this->id;
        ");

        return $this->db->execute();
    }

    public function getAll()
    {
        $this->db->prepare('
          SELECT entries.*, 
          (SELECT COUNT(*) FROM comments WHERE comments.id_entry = entries.id) as amount,
          (SELECT categories.name FROM categories WHERE categories.id = entries.id_category) as category
          FROM entries
          ');
        if ($this->db->execute()) {
            return $this->db->getRecords();
        }
    }

    public function getByCategory(string $category)
    {
        $this->db->prepare("SELECT entries.*, (
                                    SELECT categories.name 
                                    FROM categories 
                                    WHERE categories.id = $category) as category,
                                    (
                                    SELECT COUNT(*) 
                                    FROM comments 
                                    WHERE comments.id_entry = entries.id) as amount
                                  FROM entries
                                  where id_category = $category
                                  ");
        if ($this->db->execute()) {
            return $this->db->getRecords();
        }
    }

    public function getById(int $id): array
    {
        $this->db->prepare("SELECT entries.*, (
                                    SELECT categories.name 
                                    FROM categories 
                                    WHERE categories.id = entries.id_category) as category 
                                  FROM entries 
                                 WHERE id = $id");
        if ($this->db->execute()) {
            return $this->db->getRecord();
        }
    }


    public function create(Category $category)
    {

    }

    public function delete(int $id)
    {
        $this->db->prepare("DELETE FROM entries where id = $id");
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
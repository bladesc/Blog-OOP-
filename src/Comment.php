<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 03:04
 */

declare(strict_types=1);

namespace Blog;


class Comment
{
    private $id;
    private $idEntry;
    private $author;
    private $content;
    private $createdAt;
    private $updatedAt;
    private $db;

    private $errorMessages = [];

    private $textMessages = [
        "content of comment is empty",
        "added error"
    ];

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setDateCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setDateUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setAuthor(int $id): void
    {
        $this->author = $id;
    }

    public function setIdEntry(int $idEntry) {
        $this->idEntry = $idEntry;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function create()
    {
        if (!empty($this->author) && !empty($this->content) && !empty($this->idEntry)) {
            if  (!$this->insertComment()) {
                $this->addMessage($this->textMessages[1]);
            }
        } else {
            $this->addMessage($this->textMessages[0]);
        }
    }

    public function delete(int $id)
    {
        $this->db->prepare("DELETE FROM comments where id = $id");
        if (!$this->db->execute()) {
            $this->addMessage($this->textMessages[1]);
        }
    }

    public function update()
    {
        $this->db->prepare("
        UPDATE `comments` SET 
        `content` = '$this->content',
         `created_at` = '$this->createdAt',
         `updated_at` = '$this->updatedAt'
        WHERE `comments`.`id` = $this->id;
        ");

        return $this->db->execute();
    }

    public function insertComment(): bool
    {
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $this->db->prepare(
            "INSERT INTO comments (
                    id_user, 
                    content, 
                    created_at,
                    updated_at,
                    id_entry
                    ) VALUES (
                    '$this->author',
                    '$this->content',
                    '$created_at',
                    '$updated_at',
                    '$this->idEntry'
                    )"
        );

        return $this->db->execute();
    }

    public function getAll(int $idUser = null)
    {
        $query = "SELECT * FROM comments";
        if ($idUser) {
            $query .= " WHERE id_user = $idUser";
        }

        $this->db->prepare($query);

        if ($this->db->execute()) {
            return $this->db->getRecords();
        }
    }

    public function getByIdEntry(int $id)
    {
        $this->db->prepare("
          SELECT comments.*, users.login 
          FROM comments 
          LEFT JOIN users ON comments.id_user=users.id 
          WHERE comments.id_entry = $id
          ");
        if ($this->db->execute()) {
            return $this->db->getRecords();
        }
    }

    public function getById(int $id): array
    {
        $this->db->prepare("SELECT * FROM comments WHERE id = $id");
        if ($this->db->execute()) {
            return $this->db->getRecord();
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
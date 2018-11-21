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
        "some data required for comment is empty",
        "error while adding comments to database"
    ];

    /**
     * Comment constructor.
     *
     * @param Db $db
     */
    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    /**
     * It sets content for comment
     *
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * It sets data for 'created at' field
     *
     * @param string $createdAt
     */
    public function setDateCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * It sets data for 'updated at' field
     *
     * @param string $updatedAt
     */
    public function setDateUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * It sets author for comment
     *
     * @param int $id
     */
    public function setAuthor(int $id): void
    {
        $this->author = $id;
    }

    /**
     * It sets id entry
     *
     * @param int $idEntry
     */
    public function setIdEntry(int $idEntry)
    {
        $this->idEntry = $idEntry;
    }

    /**
     * It sets id for comment
     *
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * It creates comment
     */
    public function create()
    {
        if (!empty($this->author) && !empty($this->content) && !empty($this->idEntry)) {
            if (!$this->insertComment()) {
                $this->addMessage($this->textMessages[1]);
            }
        } else {
            $this->addMessage($this->textMessages[0]);
        }
    }

    /**
     * It deletes comment data by id
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->db->prepare("DELETE FROM comments where id = $id");
        if (!$this->db->execute()) {
            $this->addMessage($this->textMessages[1]);
        }
    }

    /**
     * It updates comment data by id
     *
     * @return bool
     */
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

    /**
     * It inserts comment do database
     *
     * @return bool
     */
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

    /**
     * It returns all comments data
     *
     * @param int|null $idUser
     * @return array
     */
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

    /**
     * It returns comments data by entry id
     *
     * @param int $id
     * @return array
     */
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

    /**
     * It returns data by id
     *
     * @param int $id
     * @return array
     */
    public function getById(int $id): array
    {
        $this->db->prepare("SELECT * FROM comments WHERE id = $id");
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
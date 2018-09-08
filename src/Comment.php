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
    private $author;
    private $content;
    private $createdAt;

    private $db;


    private $errorMessages = [];

    private $textMessages = [

    ];

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function create()
    {

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

    public function delete()
    {

    }

    public function update()
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
<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 06.09.2018
 * Time: 03:04
 */

namespace Blog;


class Comment
{
    private $comment;
    private $db;

    private $errorMessages = [];

    private $textMessages = [

    ];

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function addComment()
    {

    }

    public function getComments($idUser = null)
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

    public function getComment($id)
    {
        $this->db->prepare("SELECT * FROM comments WHERE id = $id");
        if ($this->db->execute()) {
            return $this->db->getRecords();
        }
    }

    public function deleteComment()
    {

    }

    public function modifyComment()
    {

    }

    public function addMessage($message)
    {
        $this->errorMessages[] = $message;
    }

    public function showMessage()
    {
        return $this->errorMessages;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 21.11.2018
 * Time: 11:57
 */

namespace Blog;


class Installation
{
    private $db;

    private $textMessages = [
        "Database is yet installed",
    ];

    public function __construct(Db $db)
    {
        if ($this->db == null) {
            $this->db = $db;
        }
        $this->install();
    }

    public function check()
    {
        $this->db->prepare("SELECT * FROM categories");
        return $this->db->execute();

    }

    public function install()
    {

        if (!$this->check()) {
            $this->installTables();
        } else {
            $this->addMessage($this->textMessages[0]);
        }

    }

    private function installTables()
    {
        $this->db->prepare("CREATE TABLE `categories` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `enabled` tinyint(1) NOT NULL,
              PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8");
        $this->db->execute();

        $this->db->prepare("CREATE TABLE `users` (
             `id` int(11) NOT NULL AUTO_INCREMENT,
             `email` varchar(255) NOT NULL,
             `password` varchar(255) NOT NULL,
             `login` varchar(255) NOT NULL,
             `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
             `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
             `remind_string` varchar(255) DEFAULT NULL,
             PRIMARY KEY (`id`),
             UNIQUE KEY `email` (`email`) USING BTREE
            ) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8");
        $this->db->execute();

        $this->db->prepare("CREATE TABLE `entries` (
             `id` int(11) NOT NULL AUTO_INCREMENT,
             `title` varchar(255) DEFAULT NULL,
             `description` text,
             `created_at` timestamp NULL DEFAULT NULL,
             `modified_at` timestamp NULL DEFAULT NULL,
             `id_category` int(11) DEFAULT NULL,
             PRIMARY KEY (`id`),
             KEY `id_category` (`id_category`),
             CONSTRAINT `entries_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
            ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8");
        $this->db->execute();

        $this->db->prepare("CREATE TABLE `comments` (
             `id` int(11) NOT NULL AUTO_INCREMENT,
             `id_user` int(11) DEFAULT NULL,
             `content` text NOT NULL,
             `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
             `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
             `id_entry` int(11) DEFAULT NULL,
             PRIMARY KEY (`id`),
             KEY `comments_user` (`id_user`),
             KEY `comments_entry` (`id_entry`),
             CONSTRAINT `comments_entry` FOREIGN KEY (`id_entry`) REFERENCES `entries` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
             CONSTRAINT `comments_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
            ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8");
        $this->db->execute();

    }

    private function installData()
    {

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
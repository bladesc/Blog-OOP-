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

    private $errorMessages = [];

    private $textMessages = [
        "Database is yet installed",
        "Database is successfully installed",
        "Data are successfully installed"
    ];

    /**
     * Installation constructor.
     *
     * @param Db $db
     */
    public function __construct(Db $db)
    {
        if ($this->db == null) {
            $this->db = $db;
        }
        $this->install();
    }

    /**
     * It checks if database exist
     *
     * @return bool
     */
    public function check(): bool
    {
        $this->db->prepare("SELECT * FROM categories");
        return $this->db->execute();

    }

    /**
     * It init install database and data
     *
     * @return void
     */
    public function install(): void
    {
        if (!$this->check()) {
            $this->installTables();
            $this->installData();
        } else {
            $this->addMessage($this->textMessages[0]);
        }
    }

    /**
     * It creates tables in database
     *
     * @return void
     */
    private function installTables(): void
    {
        $this->db->prepare("CREATE TABLE `categories` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `enabled` tinyint(1) NOT NULL,
              PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8");
        $categories = $this->db->execute();

        if (isset($categories)) {
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
            $users = $this->db->execute();
        }

        if (isset($users)) {
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
            $entries = $this->db->execute();
        }

        if (isset($entries)) {
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
            $comments = $this->db->execute();
        }

        if (isset($comments)) {
            $this->addMessage($this->textMessages[1]);
        }
    }

    /**
     * It install example data
     *
     * @return void
     */

    private function installData(): void
    {
        $this->db->prepare("INSERT INTO `categories` (
                `id`, 
                `name`, 
                `enabled`) VALUES (
                1, 
                'home', 
                '1'), (
                2, 
                'other', 
                '1');");
        $categories = $this->db->execute();

        if (isset($categories)) {
            $password = Register::generatePassword('haslo12345');
            $date = date("Y-m-d H:i:s");

            $this->db->prepare("INSERT INTO `users` (
                `id`, 
                `email`, 
                `password`, 
                `login`, 
                `created_at`, 
                `updated_at`, 
                `remind_string`) VALUES (
                1, 
                'any@email.pl', 
                '$password', 
                'login', 
                '$date', 
                '$date', 
                NULL);");
            $users = $this->db->execute();
        }

        if (isset($users)) {
            $date = date("Y-m-d H:i:s");

            $this->db->prepare("INSERT INTO `entries` (
                `id`, 
                `title`, 
                `description`, 
                `created_at`, 
                `modified_at`, 
                `id_category`) VALUES (
                NULL, 
                'lorem ipsum dolor sit amet ', 
                'lorem ipsum dolor sit amet lorem ipsum dolor sit amet', 
                '$date', 
                '$date', 
                '1');");
            $entries = $this->db->execute();
        }

        if (isset($entries)) {
            $this->addMessage($this->textMessages[2]);
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
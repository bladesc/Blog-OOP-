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

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getAll($enable = true) {
        if ($enable) {
            $this->db->prepare(
                'SELECT categories.*,(
                          SELECT count(*) FROM entries where categories.id = entries.id_category
                          ) as entries
                      FROM categories');

            if ($this->db->execute()) {
                return $this->db->getRecords();
            }
        }
    }
}
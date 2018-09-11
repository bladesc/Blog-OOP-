<?php
/**
 * Created by PhpStorm.
 * User: panx
 * Date: 11.09.2018
 * Time: 05:40
 */

namespace Blog;


class Paginator
{
    private $amountPerSites;
    private $entries = [];
    private $navigationHTML = "";
    private $paginateEntries = [];
    private $sites;

    public function __construct(array $entries, int $amountPerSites)
    {
        $this->amountPerSites = $amountPerSites;
        $this->entries = $entries;
    }

    public function getPaginateEntries(int $id): array
    {
        $totalEntries = count($this->entries);
        $this->sites = floor($totalEntries/$this->amountPerSites);

        $from = $this->amountPerSites*$id;
        $to = ($this->amountPerSites*$id) + $this->amountPerSites;

        if (isset($id)) {
            for ($i=$from; $i<$to; $i++) {
               $this->paginateEntries[] = $this->entries[$i];
            }
        }
        return $this->paginateEntries;

    }


    public function getNavigation()
    {
        $this->navigationHTML .= "<ul>";
        for ($i=0; $i<$this->sites; $i++) {
            $page = $i+1;
            $this->navigationHTML .= "<li><a href='?id=$i'>$page</a></li>";
        }
        $this->navigationHTML .= "</ul>";
        return $this->navigationHTML;
    }
}
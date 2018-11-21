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
    private $currentPage;

    public function __construct(array $entries, int $amountPerSites)
    {
        $this->amountPerSites = $amountPerSites;
        $this->entries = $entries;
    }

    public function getPaginateEntries(int $id): array
    {

        $id = $id - 1;
        $totalEntries = count($this->entries);
        $this->sites = ceil($totalEntries / $this->amountPerSites);

        $from = $this->amountPerSites * $id;
        $to = ($this->sites > 1) ? ($this->amountPerSites * $id) + $this->amountPerSites : $totalEntries;

        if ($to > $totalEntries) {
            $to = $totalEntries;
        }
      
        if (isset($id)) {
            for ($i = $from; $i < $to; $i++) {
                $this->paginateEntries[] = $this->entries[$i];
            }
        }
        return $this->paginateEntries;

    }

    public function setCurrentPage(int $currentPage)
    {
        $this->currentPage = $currentPage;
    }


    public function getNavigation()
    {

        if ($this->sites > 1) {
            $this->navigationHTML .= "<ul class='paginate'>";

            for ($i = 1; $i <= $this->sites; $i++) {
                $currentClass = ($this->currentPage == $i) ? "currentItem" : "";

                $this->navigationHTML .= ($i === 1) ? "<li><a href='?id=$i'><<</a></li>" : "";
                if ($i>$this->currentPage-2 && $i<$this->currentPage+2 ) {
                    $this->navigationHTML .= "<li><a href='?id=$i' class='$currentClass'>$i</a></li>";
                }

                $this->navigationHTML .= ($i == $this->sites) ? "<li><a href='?id=$i'>>></a></li>" : "";
            }

            $this->navigationHTML .= "</ul>";
        } else {
            $this->navigationHTML = "";
        }


        return $this->navigationHTML;
    }
}
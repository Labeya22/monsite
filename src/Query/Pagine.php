<?php

namespace Query;

use App\Helpers;

class Pagine
{
    /**
     * @var Select
     */
    private $query;
    
    /**
     * @var int
     */
    private $perPage;

    /**
     * @var int
    */
    private $currentPage;

    /**
     * @var int
    */
    private $count;

    private $pages = 0;


    /**
     * Pagine Constructor 
     *
     * @param Select $query
     * @param integer $currentPage
     * @param integer $perPage
     */
    public function __construct(Select $query, int $count,   int $currentPage = 1, int $perPage = 12)
    {
        $this->query = $query;
        $this->perPage = $perPage;
        $this->count = $count;
        $this->currentPage = $currentPage;
        $this->pages = ceil($this->count / $this->perPage);
    }

    /**
     * Retourne les resultats paginés
     * 
     * @return array
     */
    public function pagine (): array
    {
        return $this->query
        ->limit($this->perPage, ($this->perPage * ($this->currentPage - 1)))
        ->execute();
    }

    public function i ($limit = 2): ?string
    {
        if ($this->pages <= 1) return  null;

        $link = '';

        for ($i = ($this->currentPage - $limit); $i <= $this->currentPage - 1; $i++) {
            $uri = Helpers::params('page', $i);
            if ($i > 0) {
                $link .= "<li class=\"page-item\"><a href=\"{$uri}\" class=\"page-link\">{$i}</a></li>";
            }
        }

        $uri = Helpers::params('page',$this->currentPage);
        $link .= "<li class=\"page-item active\"><a href=\"{$uri}\" class=\"page-link\"  aria-current=\"{$this->currentPage}\">{$this->currentPage}</a></li>";
        

        for ($i = ($this->currentPage + 1); $i <= ($this->currentPage + $limit); $i++) {
            $uri = Helpers::params('page', $i);
            if ($i <= $this->pages) {
                $link .= "<li class=\"page-item\"><a href=\"{$uri}\" class=\"page-link\">{$i}</a></li>";
            }
            
        }


        return $link;
    }
}
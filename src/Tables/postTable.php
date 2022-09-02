<?php

namespace Tables;

use App\Helpers;
use Mapping\Post;
use Query\Pagine;

class postTable extends Table
{
    protected $from = 'posts';

    protected $mapping = Post::class;
    

    public function findPagine(array $parameters = []): Pagine
    {
        // requête de base pour la pagination des articles
        $query = $this
            ->getSelect()
            ->from($this->from)
            ->into($this->mapping);
        
        $count =  $this
            ->getSelect()
            ->from($this->from)
            ->count()->number();
        

        return new Pagine($query, $count, Helpers::getParams('page'));
    }
}


<?php

namespace Tables;

use Query\Pagine;
use Mapping\Category;
use Mapping\Post;

class CategoryTable extends Table
{
    protected $from = 'categories';

    private $join = 'post_category';

    private $to = 'posts';

    protected $mapping = Category::class;

    
    public function findPagine(array $parameters = []): Pagine
    {
        // requête de base pour la pagination des articles
        $query = $this
            ->getSelect()
            ->select('p.*')
            ->from($this->to, 'p')
            ->join("JOIN {$this->join} pc ON pc.post_id = p.id")
            ->where("pc.category_id = :id")
            ->params([':id' => $parameters['id']])
            ->into(Post::class);
        
        $count =  $this
            ->getSelect()
            ->from($this->to, 'p')
            ->join("JOIN {$this->join} pc ON pc.post_id = p.id")
            ->where("pc.category_id = :id")
            ->by('id DESC', 'createAt DESC')
            ->params([':id' => $parameters['id']])
            ->count('p.id')->number();
        

        return new Pagine($query, $count, $parameters['page'] ?? 1);
    }
}


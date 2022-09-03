<?php

namespace Tables;

use App\Helpers;
use Mapping\Category;
use Mapping\Post;
use Query\Pagine;

class postTable extends Table
{
    protected $from = 'posts';

    private $category = Category::class;

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


    public function findCategoryAssoc($id): array
    {
        return $this->getSelect()
        ->select('c.id', 'c.category', 'c.slug', 'c.createAt')
        ->from('post_category', 'pc')
        ->into($this->category)
        ->join("JOIN categories c ON c.id = pc.category_id")
        ->where('pc.post_id = :id')
        ->params([':id' => $id])
        ->execute();
    }
}


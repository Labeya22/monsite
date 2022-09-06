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
            ->by('p.id DESC', 'p.createAt DESC')
            ->params([':id' => $parameters['id']])
            ->into(Post::class);
        
        $count =  $this
            ->getSelect()
            ->from($this->to, 'p')
            ->join("JOIN {$this->join} pc ON pc.post_id = p.id")
            ->where("pc.category_id = :id")
            ->params([':id' => $parameters['id']])
            ->count('p.id')->number();
        

        return new Pagine($query, $count, $parameters['page'] ?? 1);
    }



    public function findPagineCategory(array $parameters = []): Pagine
    {
        // requête de base pour la pagination des articles
        $query = $this
             ->getSelect()
             ->from($this->from)
             ->by('id DESC', 'createAt DESC')
             ->into($this->mapping);

        $count = $this->getSelect()
        ->from($this->from)
        ->count('id')->number();

        return new Pagine($query, $count, $parameters['page'] ?? 1);
    }

    public function editer(Category $category): bool
    {
        return $this->getUpdate()
            ->from($this->from)
            ->update('category = :category', 'createAt = :createAt')
            ->where('id = :id')
            ->params([
                ':id' => $category->getId(),
                ':category' => $category->getCategory(),
                ':createAt' => $category->getCreateAt()->format('Y-m-d H:m:s')
            ])
        ->execute();
    }

    public function create(Category $category): bool
    {
        return $this->getInsert()
            ->from($this->from)
            ->insert('category = :category', 'createAt = NOW()', 'id = :id')
            ->params([
                ':id' => token(24),
                ':category' => $category->getCategory()
            ])
        ->execute();
    }
}


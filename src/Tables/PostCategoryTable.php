<?php

namespace Tables;

use Query\Pagine;
use Mapping\PostCategory;

class PostCategoryTable extends Table
{

    protected $from = 'post_category';

    private $init = 'posts';

    private $end = 'categories';

    protected $mapping = PostCategory::class;



    public function findPagine(array $parameters = []): Pagine
    {
        // requête de base pour la pagination des articles
        $query = $this
        ->getSelect()
            ->select('p.name', 'c.category', 'pc.id')
            ->from($this->from, 'pc')
            ->join("JOIN {$this->init} p ON p.id = pc.post_id")
            ->join("JOIN {$this->end} c ON c.id = pc.category_id")
            ->by('p.name DESC', 'c.category DESC', 'pc.id DESC')
            ->into($this->mapping);
            
        
        $count =  $this
            ->getSelect()
            ->select('pc.id')
            ->from($this->from, 'pc')
            ->join("JOIN {$this->init} p ON p.id = pc.post_id")
            ->join("JOIN {$this->end} c ON c.id = pc.category_id")
            ->count('pc.id')->number();

        return new Pagine($query, $count, $parameters['page'] ?? 1);
    }

    public function create(PostCategory $postCategory): bool
    {
        return $this->getInsert()
            ->from($this->from)
            ->insert('category_id = :category', 'post_id = :post', 'id = :id')
            ->params([
                ':id' => token(24),
                ':category' => $postCategory->getCategoryId(),
                ':post' => $postCategory->getPostId()
            ])
        ->execute();
    }

    
    public function editer(PostCategory $postCategory): bool
    {
        return $this->getUpdate()
            ->from($this->from)
            ->update('category_id = :category', 'post_id = :post')
            ->where('id = :id')
            ->params([
                ':category' => $postCategory->getCategoryId(),
                ':post' => $postCategory->getPostId(),
                ':id' => $postCategory->getId()
            ])
        ->execute();
    }

    
    public function findAll ($fields, $indexes = null): array
    {
        $query =  $this->getSelect()->from($this->from)->into($this->mapping);

        foreach($fields as $key => $value) {
            $query->where("$key = :$key")->params([":$key" => $value]);
        }
      
        if (!is_null($indexes)) {
            $query->where("id != :indexes")->params([":indexes" => $indexes]);
        }
        
        return $query->execute();
    }
}
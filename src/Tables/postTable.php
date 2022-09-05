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

    private $assoc = 'post_category';

    private $to = 'categories';

    protected $mapping = Post::class;


    public function editer(Post $post): bool
    {
        return $this->getUpdate()
            ->from($this->from)
            ->update('name = :name', 'slug = :slug', 'content = :content', 'createAt = :createAt')
            ->where('id = :id')
            ->params([
                ':id' => $post->getId(),
                ':name' => $post->getName(),
                ':slug' => $post->getSlug(),
                ':content' => $post->getContent(),
                ':createAt' => $post->getCreateAt()->format('Y-m-d H:m:s')
            ])
        ->execute();
    }
    

    public function findPagine(array $parameters = []): Pagine
    {
        // requête de base pour la pagination des articles
        $query = $this
            ->getSelect()
            ->from($this->from)
            ->by('id DESC', 'createAt DESC')
            ->into($this->mapping);
        
        $count =  $this
            ->getSelect()
            ->from($this->from)
            ->count()->number();
        

        return new Pagine($query, $count, getParams('page'));
    }


    /**
     *
     * @param array $parameters
     * @return Category[]
     */
    public function category_assoc(array $parameters): array
    {
        $merge = array_map(function ($id) {
            return "'$id'";
        }, $parameters['in']);
        return $this->getSelect()
        ->select("c.*", 'pc.post_id')
        ->from($this->assoc, 'pc')
        ->join("JOIN  {$this->to} c ON c.id = pc.category_id")
        ->in('pc.post_id', implode(', ', $merge))
        ->into($this->category)
        ->execute();
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


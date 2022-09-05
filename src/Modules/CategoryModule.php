<?php


namespace Modules;

use Config\Config;
use App\Routes\Router;
use App\Renderer\Renderer;
use App\Exceptions\NotFoundException;
use App\Helpers;
use Tables\CategoryTable;
use Tables\postTable;

class CategoryModule
{
    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var Router
     */
    private $router;

    
    private $category;

    private $post;

    public function __construct(Renderer $render, Router $router)
    {
        $this->renderer = $render;
        $this->router = $router;
        
        
        // la route vers asset
        $router->get('/category/:category.html', [$this, 'show'], 'category.show')->regex('category', "[a-zA-Z0-9]+");

        $this->category = new CategoryTable(Config::getPDO());
        $this->post = new postTable(Config::getPDO());
    }


    public function show ($category){
        $find = $this->category->find('id', $category);

        if (empty($find)) {
            throw new NotFoundException("Nous avons pas pu trouver la categorie #$category");
        }

        $pagine = $this->category->findPagine(['page' => getParams('page'), 'id' => $find[0]->getId() ]);

        $posts = $pagine->pagine();
        $category_assoc = [];
        $paginate = $pagine->i(3);

        foreach($posts as $post) {
            $category_assoc[$post->getId()] = $post;
        }

        $categories = $this->post->category_assoc(['in' => array_keys($category_assoc)]);
    
        foreach ($categories as $category) {
            $category_assoc[$category->getPostId()]->setCategory($category);
        } 



        return $this->renderer->render('categories/show', compact('find', 'posts', 'paginate'));
    }

}
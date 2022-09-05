<?php

namespace Modules;

use App\Exceptions\NotFoundException;
use Config\Config;
use Tables\postTable;
use App\Routes\Router;
use App\Renderer\Renderer;

class BlogModule {

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var postTable
     */
    private $post;

    /**
     * @param Renderer $render
     * @param Router $router
     */
    public function __construct(Renderer $render, Router $router)
    {
        $this->renderer = $render;
        $this->router = $router;
        
        
        // la route vers l'accueil
        $router->get('/', [$this, 'index'], 'blog.index');
        $router->get('/blog/show-:id', [$this, 'show'], 'blog.show')->regex('id', "[a-z0-9]+");


        $this->post = new postTable(Config::getPDO());


    }
    

    public function index() {

        $pagine = $this->post->findPagine();
        $posts = $pagine->pagine();
        $category_assoc = [];
        $paginate = $pagine->i(3);

        if (!empty($posts)) {
            foreach($posts as $post) {
                $category_assoc[$post->getId()] = $post;
            }

            $categories = $this->post->category_assoc(['in' => array_keys($category_assoc)]);
        
            foreach ($categories as $category) {
                $category_assoc[$category->getPostId()]->setCategory($category);
            }    
        }

        return $this->renderer->render('blog/index', compact('posts', 'paginate'));
    }

    public function show (string $id)
    {  
        $find = $this->post->find('id', $id);
        if (empty($find)) {
            throw new NotFoundException("Nous avons pas pu trouver l'article #$id");
        }


        $categories = $this->post->findCategoryAssoc($id);
        
        return $this->renderer->render('blog/show', compact('find', 'categories'));
    }
}
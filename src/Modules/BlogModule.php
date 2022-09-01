<?php

namespace Modules;

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
        $router->get('/', [$this, 'index'], 'home');
        $router->get('/blog/show-:id', [$this, 'show'], 'blog.show')->regex('id', "[a-z]+");


        $this->post = new postTable(Config::getPDO());


    }
    

    public function index() {
        $posts = $this->post->all();
        // dd($posts);
        return $this->renderer->render('blog/index', compact('posts'));
    }

    public function show (string $id)
    {  
        return $this->renderer->render('blog/show');
    }
}
<?php

namespace Modules;


use Config\Config;
use Tables\postTable;
use App\Routes\Router;
use App\Renderer\Renderer;
use App\Exceptions\NotFoundException;

class AdminModule {

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

        $this->router->get('/admin/posts/index.html', [$this, 'posts'], 'admin.posts.index');
        $this->router->get('/admin/posts/post-:id.html', [$this, 'post'], 'admin.posts.post');
        $this->router->get('/admin/posts/delete-:id.html', [$this, 'post_delete'], 'admin.post.delete');

        $this->post = new postTable(Config::getPDO());
        
    }

    public function posts ()
    {
        $pagine = $this->post->findPagine(['page' => getParams('page')]);
        $posts = $pagine->pagine();
        $paginate = $pagine->i(3);
        return $this->renderer->render('admin/posts/index', compact('posts', 'paginate'), 'admin');
    }

    
    public function post (string $id)
    {
        
        return $this->renderer->render('admin/posts/post', [], 'admin');
    }

    public function post_delete(string $id)
    {
        $post = $this->post->find($id);
        if (empty($post)) {
            throw new NotFoundException("Nous avons pas pu trouver l'article #$id");
        }

        if ($this->post->delete($id)) {
            r($this->router->generateUri('admin.posts.index'));
        } else {
            r($this->router->generateUri('admin.posts.index'));
        }

    }

}
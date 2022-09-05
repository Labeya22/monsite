<?php

namespace Modules;


use App\Flash;
use App\Message;
use Config\Config;
use Tables\postTable;
use App\Routes\Router;
use Validator\Validator;
use App\Renderer\Renderer;
use App\Exceptions\NotFoundException;
use Validations\PostValidator;

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
        $this->router->both('/admin/posts/delete-:id.html', [$this, 'post_delete'], 'admin.post.delete');
        $this->router->both('/admin/posts/edit-:id.html', [$this, 'post_editer'], 'admin.post.editer');

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
        $post = $this->post->find('id', $id);
        if (empty($post)) {
            throw new NotFoundException("Nous avons pas pu trouver l'article #$id");
        }

        if ($this->post->delete($id)) {
            Flash::instance()->write('success', "l'article #$id a été supprimer avec succès");
            r($this->router->generateUri('admin.posts.index'));
        } else {
            Flash::instance()->write('danger', "Nous avons pas pu supprimer l'atrticle #$id");
            r($this->router->generateUri('admin.posts.index'));
        }


    }

    
    public function post_editer(string $id)
    {
        $post = $this->post->find('id', $id);
        if (empty($post)) {
            throw new NotFoundException("Nous avons pas pu trouver l'article #$id");
        }

        $errors = [];
        if (!empty($_POST)) {
            hydrate($post[0], $_POST, ['name', 'slug', 'content', 'createAt']);
            $validator = new PostValidator($_POST, $this->post, $post[0]->getId());
            
            if (!$validator->validate()) {
                $errors = $validator->getErrors();
                Flash::instance()->write('danger', "Nous avons pas pu editer l'article #$id, merci de corriger vos erreurs.");
            } else {
                if ($this->post->editer($post[0])) {
                    Flash::instance()->write('success', "l'article #$id a été mis à jour.");
                    r($this->router->generateUri('admin.posts.index'));
                }
            }
        }

        return $this->renderer->render('admin/posts/editer', compact('post', 'errors'), 'admin');
    }

}
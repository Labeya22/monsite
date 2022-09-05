<?php

namespace Modules;


use App\Flash;
use Mapping\{Post, Category};
use Config\Config;
use Tables\postTable;
use App\Routes\Router;
use App\Renderer\Renderer;
use Validations\PostValidator;
use App\Exceptions\NotFoundException;
use Tables\CategoryTable;
use Validations\CategoryValidator;

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
     * @var CategoryTable
     */
    private $category;

    /**
     * @param Renderer $render
     * @param Router $router
     */
    public function __construct(Renderer $render, Router $router)
    {
        $this->renderer = $render;
        $this->router = $router;

        // POSTS
        $this->router->get('/admin/posts/index.html', [$this, 'posts'], 'admin.posts.index');
        $this->router->get('/admin/posts/post-:id.html', [$this, 'post'], 'admin.posts.show')->regex('id', "[a-zA-Z0-9]+");
        $this->router->both('/admin/posts/delete-:id.html', [$this, 'post_delete'], 'admin.post.delete')->regex('id', "[a-zA-Z0-9]+");
        $this->router->both('/admin/posts/edit-:id.html', [$this, 'post_editer'], 'admin.post.editer')->regex('id', "[a-zA-Z0-9]+");
        $this->router->both('/admin/posts/create.html', [$this, 'post_create'], 'admin.post.create');

        // CATEGORIES
        $this->router->get('/admin/categories/index.html', [$this, 'categories'], 'admin.categories.index');
        $this->router->both('/admin/categories/delete-:id.html', [$this, 'category_delete'], 'admin.category.delete')->regex('id', "[a-zA-Z0-9]+");
        $this->router->both('/admin/categories/edit-:id.html', [$this, 'category_editer'], 'admin.category.editer')->regex('id', "[a-zA-Z0-9]+");
        $this->router->both('/admin/categories/create.html', [$this, 'category_create'], 'admin.category.create');
        $this->router->both('/admin/categories/show-:id.html', [$this, 'category'], 'admin.categories.show')->regex('id', "[a-zA-Z0-9]+");

        $this->post = new postTable(Config::getPDO());
        $this->category = new CategoryTable(Config::getPDO());
        
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
        $post = $this->post->find('id', $id);
        if (empty($post)) {
            throw new NotFoundException("Nous avons pas pu trouver l'article #$id");
        }

        return $this->renderer->render('admin/posts/show', compact('post'), 'admin');
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

    public function post_create()
    {
        $post = new Post();
        $errors = [];
        if (!empty($_POST)) {
            hydrate($post, $_POST, ['name', 'slug', 'content']);
            $validator = new PostValidator($_POST, $this->post);
            
            if (!$validator->validate()) {
                $errors = $validator->getErrors();
                Flash::instance()->write('danger', "Nous avons pas pu créer l'article {$post->getName()}, merci de corriger vos erreurs.");
            } else {
                if ($this->post->create($post)) {
                    Flash::instance()->write('success', "Vous avez enregistré un article");
                    r($this->router->generateUri('admin.posts.index'));
                }
            }
        }
        
        
        return $this->renderer->render('admin/posts/create', compact('post', 'errors'), 'admin');
    }

    public function categories()
    {
        $pagine = $this->category->findPagineCategory(['page' => getParams('page')]);
        $categories = $pagine->pagine();
        $paginate = $pagine->i(3);
        return $this->renderer->render('admin/categories/index', compact('categories', 'paginate'), 'admin');
    }

    public function category(string $id)
    {
        $category = $this->category->find('id', $id);
        if (empty($category)) {
            throw new NotFoundException("Nous avons pas pu trouver la categorie #$id");
        }
        return $this->renderer->render('admin/categories/show', compact('category'), 'admin');
    }

    public function category_delete(string $id)
    {
        $category = $this->category->find('id', $id);
        if (empty($category)) {
            throw new NotFoundException("Nous avons pas pu trouver la categorie #$id");
        }

        if ($this->category->delete($id)) {
            Flash::instance()->write('success', "la categorie #$id a été supprimer avec succès");
            r($this->router->generateUri('admin.categories.index'));
        } else {
            Flash::instance()->write('danger', "Nous avons pas pu supprimer la categorie #$id");
            r($this->router->generateUri('admin.categories.index'));
        }
    }

    public function category_editer(string $id)
    {
        $category = $this->category->find('id', $id);
        if (empty($category)) {
            throw new NotFoundException("Nous avons pas pu trouver la categorie #$id");
        }

        $errors = [];
        if (!empty($_POST)) {
            hydrate($category[0], $_POST, ['category', 'slug', 'createAt']);
            $validator = new CategoryValidator($_POST, $this->category, $category[0]->getId());

            if (!$validator->validate()) {
                $errors = $validator->getErrors();
                Flash::instance()->write('danger', "Nous avons pas pu editer la categorie #$id, merci de corriger vos erreurs.");
            } else {
                if ($this->category->editer($category[0])) {
                    Flash::instance()->write('success', "la categorie #$id a été mis à jour.");
                    r($this->router->generateUri('admin.categories.index'));
                }
            }
        }
        
        return $this->renderer->render('admin/categories/editer', compact('category', 'errors'), 'admin');
    }


    public function category_create()
    {
        $errors = [];
        $category = new Category();
        if (!empty($_POST)) {
            hydrate($category, $_POST, ['category', 'slug']);
            $validator = new CategoryValidator($_POST, $this->category);

            if (!$validator->validate()) {
                $errors = $validator->getErrors();
                Flash::instance()->write('danger', "Nous avons pas pu créer l'article {$category->getCategory()}, merci de corriger vos erreurs.");
            } else {
                if ($this->category->create($category)) {
                    Flash::instance()->write('success', "Vous avez enregistré une categorie");
                    r($this->router->generateUri('admin.categories.index'));
                }
            }
        }

        return $this->renderer->render('admin/categories/create', compact('category', 'errors'), 'admin');

    }

}
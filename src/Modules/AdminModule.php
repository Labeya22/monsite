<?php

namespace Modules;

use App\Auth;
use App\Flash;
use Mapping\{Post, Category, PostCategory};
use Config\Config;
use App\Routes\Router;
use App\Renderer\Renderer;
use Validations\PostValidator;
use App\Exceptions\NotFoundException;
use Validations\CategoryValidator;
use Tables\{PostCategoryTable, CategoryTable, postTable};
use Validations\RelationValidator;

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
     * @var PostCategoryTable
     */
    private $relation;

    /**
     * @param Renderer $render
     * @param Router $router
     */
    public function __construct(Renderer $render, Router $router)
    {
        $this->renderer = $render;
        $this->router = $router;

        $this->router->get('/admin/index.html', [$this, 'index'], 'admin.index');

        // POSTS
        $this->router->get('/admin/posts.html', [$this, 'posts'], 'admin.posts.index');
        $this->router->get('/admin/posts/post-:id.html', [$this, 'post'], 'admin.posts.show')->regex('id', "[a-zA-Z0-9]+");
        $this->router->both('/admin/posts/delete-:id.html', [$this, 'post_delete'], 'admin.post.delete')->regex('id', "[a-zA-Z0-9]+");
        $this->router->both('/admin/posts/edit-:id.html', [$this, 'post_editer'], 'admin.post.editer')->regex('id', "[a-zA-Z0-9]+");
        $this->router->both('/admin/posts/create.html', [$this, 'post_create'], 'admin.post.create');

        // CATEGORIES
        $this->router->get('/admin/categories.html', [$this, 'categories'], 'admin.categories.index');
        $this->router->both('/admin/categories/delete-:id.html', [$this, 'category_delete'], 'admin.category.delete')->regex('id', "[a-zA-Z0-9]+");
        $this->router->both('/admin/categories/edit-:id.html', [$this, 'category_editer'], 'admin.category.editer')->regex('id', "[a-zA-Z0-9]+");
        $this->router->both('/admin/categories/create.html', [$this, 'category_create'], 'admin.category.create');
        $this->router->both('/admin/categories/show-:id.html', [$this, 'category'], 'admin.categories.show')->regex('id', "[a-zA-Z0-9]+");


        // RELATIONS
        $this->router->both('/admin/relations.html', [$this, 'relations'], 'admin.relations.index');
        $this->router->both('/admin/relations/create', [$this, 'relation_create'], 'admin.relation.create');
        $this->router->both('/admin/relations/delete-:id.html', [$this, 'relation_delete'], 'admin.relation.delete');
        $this->router->both('/admin/relations/editer-:id.html', [$this, 'relation_editer'], 'admin.relation.editer');


        $this->post = new postTable(Config::getPDO());
        $this->category = new CategoryTable(Config::getPDO());
        $this->relation = new PostCategoryTable(Config::getPDO());

        Auth::route($this->router);




        
    }

    public function index()
    {
        Auth::check();
        return $this->renderer->render('admin/index', [], 'admin');
    }

    public function posts ()
    {
        Auth::check();

        $pagine = $this->post->findPagine(['page' => getParams('page')]);
        $posts = $pagine->pagine();
        $paginate = $pagine->i(3);
        return $this->renderer->render('admin/posts/index', compact('posts', 'paginate'), 'admin');
    }

    public function post (string $id)
    {
        Auth::check();

        $post = $this->post->find('id', $id);
        if (empty($post)) {
            throw new NotFoundException("Nous avons pas pu trouver l'article #$id");
        }

        return $this->renderer->render('admin/posts/show', compact('post'), 'admin');
    }

    public function post_delete(string $id)
    {
        Auth::check();

        $post = $this->post->find('id', $id);
        if (empty($post)) {
            throw new NotFoundException("Nous avons pas pu trouver l'article #$id");
        }

        if ($this->post->delete($id)) {
            Flash::instance()->write('success', "l'article #$id a ??t?? supprimer avec succ??s");
            r($this->router->generateUri('admin.posts.index'));
        } else {
            Flash::instance()->write('danger', "Nous avons pas pu supprimer l'atrticle #$id");
            r($this->router->generateUri('admin.posts.index'));
        }


    }
  
    public function post_editer(string $id)
    {
        Auth::check();

        $post = $this->post->find('id', $id);
        if (empty($post)) {
            throw new NotFoundException("Nous avons pas pu trouver l'article #$id");
        }

        $errors = [];
        if (!empty($_POST)) {
            hydrate($post[0], $_POST, ['name', 'content', 'createAt']);
            $validator = new PostValidator($_POST, $this->post, $post[0]->getId());
            
            if (!$validator->validate()) {
                $errors = $validator->getErrors();
                Flash::instance()->write('danger', "Nous avons pas pu editer l'article #$id, merci de corriger vos erreurs.");
            } else {
                if ($this->post->editer($post[0])) {
                    Flash::instance()->write('success', "l'article #$id a ??t?? mis ?? jour.");
                    r($this->router->generateUri('admin.posts.index'));
                }
            }
        }

        return $this->renderer->render('admin/posts/editer', compact('post', 'errors'), 'admin');
    }

    public function post_create()
    {
        Auth::check();

        $post = new Post();
        $errors = [];
        if (!empty($_POST)) {
            hydrate($post, $_POST, ['name', 'content']);
            $validator = new PostValidator($_POST, $this->post);
            
            if (!$validator->validate()) {
                $errors = $validator->getErrors();
                Flash::instance()->write('danger', "Nous avons pas pu cr??er l'article {$post->getName()}, merci de corriger vos erreurs.");
            } else {
                if ($this->post->create($post)) {
                    Flash::instance()->write('success', "Vous avez enregistr?? un article");
                    r($this->router->generateUri('admin.posts.index'));
                }
            }
        }
        
        
        return $this->renderer->render('admin/posts/create', compact('post', 'errors'), 'admin');
    }

    public function categories()
    {
        Auth::check();

        $pagine = $this->category->findPagineCategory(['page' => getParams('page')]);
        $categories = $pagine->pagine();
        $paginate = $pagine->i(3);
        return $this->renderer->render('admin/categories/index', compact('categories', 'paginate'), 'admin');
    }

    public function category(string $id)
    {
        Auth::check();

        $category = $this->category->find('id', $id);
        if (empty($category)) {
            throw new NotFoundException("Nous avons pas pu trouver la categorie #$id");
        }
        return $this->renderer->render('admin/categories/show', compact('category'), 'admin');
    }

    public function category_delete(string $id)
    {
        Auth::check();

        $category = $this->category->find('id', $id);
        if (empty($category)) {
            throw new NotFoundException("Nous avons pas pu trouver la categorie #$id");
        }

        if ($this->category->delete($id)) {
            Flash::instance()->write('success', "la categorie #$id a ??t?? supprimer avec succ??s");
            r($this->router->generateUri('admin.categories.index'));
        } else {
            Flash::instance()->write('danger', "Nous avons pas pu supprimer la categorie #$id");
            r($this->router->generateUri('admin.categories.index'));
        }
    }

    public function category_editer(string $id)
    {
        Auth::check();

        $category = $this->category->find('id', $id);
        if (empty($category)) {
            throw new NotFoundException("Nous avons pas pu trouver la categorie #$id");
        }

        $errors = [];
        if (!empty($_POST)) {
            hydrate($category[0], $_POST, ['category', 'createAt']);
            $validator = new CategoryValidator($_POST, $this->category, $category[0]->getId());

            if (!$validator->validate()) {
                $errors = $validator->getErrors();
                Flash::instance()->write('danger', "Nous avons pas pu editer la categorie #$id, merci de corriger vos erreurs.");
            } else {
                if ($this->category->editer($category[0])) {
                    Flash::instance()->write('success', "la categorie #$id a ??t?? mis ?? jour.");
                    r($this->router->generateUri('admin.categories.index'));
                }
            }
        }
        
        return $this->renderer->render('admin/categories/editer', compact('category', 'errors'), 'admin');
    }


    public function category_create()
    {
        Auth::check();

        $errors = [];
        $category = new Category();
        if (!empty($_POST)) {
            hydrate($category, $_POST, ['category']);
            $validator = new CategoryValidator($_POST, $this->category);

            if (!$validator->validate()) {
                $errors = $validator->getErrors();
                Flash::instance()->write('danger', "Nous avons pas pu cr??er l'article {$category->getCategory()}, merci de corriger vos erreurs.");
            } else {
                if ($this->category->create($category)) {
                    Flash::instance()->write('success', "Vous avez enregistr?? une categorie");
                    r($this->router->generateUri('admin.categories.index'));
                }
            }
        }

        return $this->renderer->render('admin/categories/create', compact('category', 'errors'), 'admin');

    }

    public function relations()
    {   
        Auth::check();

        $pagine = $this->relation->findPagine(['page' => getParams('page')]);
        $relations = $pagine->pagine();
        $paginate = $pagine->i(4);

        return $this->renderer->render('admin/relations/index', compact('relations', 'paginate'), 'admin');
    }

    public function relation_create()
    {
        Auth::check();

        $errors = [];
        $relation = new PostCategory;


        if (!empty($_POST)) {
            hydrate($relation, $_POST, ['post_id', 'category_id']);
            $validator = new RelationValidator($_POST, $this->relation, null);

            if (!$validator->validate()) {
                $errors = $validator->getErrors();
                if (array_key_exists('both', $errors)) {
                    Flash::instance()->write('danger', implode('<br>', $errors['both']));
                }
            }else {
                if ($this->relation->create($relation)) {
                    Flash::instance()->write('success', "Une relation a ??t?? ajouter avec succ??s");
                    r($this->router->generateUri('admin.relations.index'));
                }
            }
        }


        $categories = $this->category->all(['id', 'category']);
        $posts = $this->post->all(['id', 'name']);
        return $this->renderer->render('admin/relations/create', compact('posts', 'errors', 'categories', 'relation'), 'admin');
    }

    public function relation_delete(string $id)
    {
        Auth::check();

        $relation = $this->relation->find('id', $id);
        if (empty($relation)) {
            throw new NotFoundException("Nous avons pas pu trouver la relation #$id");
        }

        if ($this->relation->delete($relation[0]->getId())) {
            Flash::instance()->write('success', "la relation #$id a ??t?? supprimer avec succ??s");
            r($this->router->generateUri('admin.relations.index'));
        } else {
            Flash::instance()->write('danger', "Nous avons pas pu supprimer la relation #$id");
            r($this->router->generateUri('admin.relations.index'));
        }
    }

    public function relation_editer(string $id)
    {
        Auth::check();

        $relation = $this->relation->find('id', $id);
        if (empty($relation)) {
            throw new NotFoundException("Nous avons pas pu trouver la relation #$id");
        }

        $errors = [];
        if (!empty($_POST)) {
            hydrate($relation[0], $_POST, ['post_id', 'category_id']);
            $validator = new RelationValidator($_POST, $this->relation, $relation[0]->getId());

            if (!$validator->validate()) {
                $errors = $validator->getErrors();
                if (array_key_exists('both', $errors)) {
                    Flash::instance()->write('danger', implode('<br>', $errors['both']));
                }
            }else {
                if ($this->relation->editer($relation[0])) {
                    Flash::instance()->write('success', "La relation #$id a ??t?? mis ?? jour");
                    r($this->router->generateUri('admin.relations.index'));
                }
            }
        }

        $categories = $this->category->all(['id', 'category']);
        $posts = $this->post->all(['id', 'name']);
        
        return $this->renderer->render('admin/relations/editer', compact('relation', 'errors', 'categories', 'posts'), 'admin');
    }
}
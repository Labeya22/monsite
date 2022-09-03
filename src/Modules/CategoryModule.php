<?php


namespace Modules;

use Config\Config;
use App\Routes\Router;
use App\Renderer\Renderer;
use App\Exceptions\NotFoundException;
use Tables\CategoryTable;

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

    public function __construct(Renderer $render, Router $router)
    {
        $this->renderer = $render;
        $this->router = $router;
        
        
        // la route vers asset
        $router->get('/category/:category.html', [$this, 'category'], 'category.show')->regex('category', "[a-z0-9]+");

        $this->category = new CategoryTable(Config::getPDO());
    }


    public function category ($category){
        $find = $this->category->find($category);

        if (empty($find)) {
            throw new NotFoundException("Nous avons pas pu trouver la categorie #$category");
        }

        return $this->renderer->render('categories/show', compact('find'));
    }

}
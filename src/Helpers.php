<?php

use App\Routes\Router;
use Mapping\Category;

function hydrate($instance, $data): array
{
    $hydrate = [];
    foreach($data as $k => $v) {
        
    }

    return $hydrate;
}

function params($key, $value): string
{
    return "?$key=$value";
}

function getParams($key): int
{
    if (!isset($_GET[$key])) return 1;
    
    $value = $_GET[$key];
    if ($value <= 0) {
        return 1;
    }

    return $value;
}

function e ($string): string
{
    return htmlentities($string);
}


/**
 *
 * @param Category[]
 * @param Router $router
 * @return string|null
 */
function category_assoc_generate (array $categories, Router $router): ?string
{
    $links = array_map(function ($category) use ($router) {
        $link = $router->generateUri('category.show', [
            'category' => $category->getId()
        ]);
        return <<< HTML
        <a href="{$link}"> {$category->getCategory()} </a>
HTML;
    }, $categories);
    
    return implode(', ', $links);
}

function li ($link, $title): string
{
    $active = $_SERVER['REQUEST_URI'] == $link ? 'active' : '';
    return <<< HTML
    <li class="nav-item">
        <a class="nav-link {$active}" href="{$link}">{$title}</a>
    </li>
HTML;
}

function r ($link): void
{
    header("Location: $link");
    exit();
}
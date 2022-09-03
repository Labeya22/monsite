<?php

namespace Tables;

use Mapping\Category;

class CategoryTable extends Table
{
    protected $from = 'categories';

    protected $mapping = Category::class;
}


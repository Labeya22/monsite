<?php

namespace Tables;

use Mapping\Post;

class postTable extends Table
{
    protected $from = 'posts';

    protected $mapping = Post::class;
}
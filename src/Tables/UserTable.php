<?php

namespace Tables;

use Mapping\User;

class UserTable extends Table
{
    protected $from = 'user';

    protected $mapping = User::class;



}
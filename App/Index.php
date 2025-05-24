<?php

use App\Controllers\IndexController;

class Index
{

    public function __construct()
    {
        require_once  ('/App/Core/Autoload.php');
    }

    public function execute()
    {
        return new IndexController;
    }
}

(new Index())->execute();
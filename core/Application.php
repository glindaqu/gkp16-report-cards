<?php

require_once "Router.php";

class Application
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

}
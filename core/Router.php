<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/controllers/StatisticController.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/controllers/AttendanceController.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/View.php";

class Router
{
    private string $controller = "statistic";
    private string $action = "index";

    public function __construct()
    {
        $splitted = explode("/", $_SERVER['REQUEST_URI']);
        $given_action = trim($splitted[3]);
        $given_controller = trim($splitted[2]);

        if ($given_action !== "") 
        {
            $this->action = $given_action;
        }

        if ($given_controller !== "") 
        {
            $this->controller = $given_controller;
        }

        $this->navigate();
    }

    public function navigate(): void
    {
        $path = ucfirst($this->controller . 'Controller');
        if (!class_exists($path) || !method_exists($path, $this->action)) 
        {
            View::page_not_found();
            exit;
        }
        $controller = new $path();
        $action = $this->action;
        $controller->$action();
    }

    public function route_dump(): string
    {
        return "action: $this->action, controller: $this->controller";
    }
}
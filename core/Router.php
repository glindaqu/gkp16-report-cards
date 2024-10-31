<?php

require_once "controllers/StatisticController.php";

class Router {
    private string $controller = "statistic";
    private string $action = "/";

    public function __construct() {
        $splitted = explode("/", $_SERVER['REQUEST_URI']);
        $given_action = trim($splitted[3]);
        $given_controller = trim($splitted[2]);
        
        if ($given_action !== "") {
            $this->action = $given_action;
        }

        if ($given_controller !== "") {
            $this->controller = $given_controller;
        }

        $this->navigate();
    }

    public function navigate(): void {
        $path = ucfirst($this->controller.'Controller');
        if (class_exists($path)) {
            if (method_exists($path, $this->action)) {
                $controller = new $path();
                $action = $this->action;
                $controller->$action();
            } else {
                echo "<br> * Action not found! Action: $this->action <br>";
            }
        } else {
            echo "<br> * Controller not found! Controller: $path <br>";
        }
    }

    public function route_dump(): string {
        return "action: $this->action, controller: $this->controller";
    }
}
<?php

class Application {

    public function __construct() {
        echo $_SERVER['REQUEST_URI'];
    }

}
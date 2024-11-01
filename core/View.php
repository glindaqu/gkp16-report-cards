<?php

class View
{
    public static function page_not_found(): void
    {
        require "templates/404.php";
    }
}
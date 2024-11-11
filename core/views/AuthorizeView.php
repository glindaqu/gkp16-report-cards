<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/View.php";

class AuthorizeView extends View
{
    public function auth(): void
    {
        ob_start();
        require $_SERVER['DOCUMENT_ROOT'] . '/report/templates/auth/index.php';
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    public function error(): void
    {
        ob_start();
        require $_SERVER['DOCUMENT_ROOT'] . '/report/templates/auth/error.php';
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
}
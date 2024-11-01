<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/View.php";

class StatisticView extends View
{
    public function index(): void
    {
        ob_start();
        require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/statistic/index.php";
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
}
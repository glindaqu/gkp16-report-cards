<?php

class StatisticController {
    function index(): void {
         ob_start();
         require "core/views/statistic/index.php";
         $content = ob_get_contents();
         ob_end_clean();
         echo $content;
    }
}
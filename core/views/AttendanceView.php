<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/View.php";

class AttendanceView extends View
{
    public function index(array $employes, string $role): void
    {
        ob_start();
        require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/attendance/index.php";
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
}
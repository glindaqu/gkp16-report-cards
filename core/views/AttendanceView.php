<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/View.php";

class AttendanceView extends View
{
    public function index(): void
    {
        require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/attendance/index.php";
    }
}
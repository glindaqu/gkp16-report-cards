<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/views/AttendanceView.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Controller.php";

class AttendanceController extends Controller
{
    private AttendanceView $view;

    public function __construct()
    {
        $this->view = new AttendanceView();
    }

    public function index(): void
    {
        $this->view->index();
    }
}
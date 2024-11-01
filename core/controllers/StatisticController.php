<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/views/StatisticView.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Controller.php";

class StatisticController extends Controller
{

    private StatisticView $view;

    public function __construct()
    {
        $this->view = new StatisticView();
    }

    function index(): void
    {
        $this->view->index();
    }
}
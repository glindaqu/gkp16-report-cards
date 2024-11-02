<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/views/StatisticView.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Controller.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/EmployeeModel.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/AttendanceModel.php";

class StatisticController extends Controller
{
    private EmployeeModel $employee_model;
    private AttendanceModel $attendance_model;
    private StatisticView $view;

    public function __construct()
    {
        $this->view = new StatisticView();
        $this->employee_model = new EmployeeModel();
        $this->attendance_model = new AttendanceModel();
    }

    function index(): void
    {
        $this->view->index($this->employee_model->get_all(), $this->attendance_model->get_all());
    }
}
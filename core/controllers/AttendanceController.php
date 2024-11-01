<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/views/AttendanceView.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Controller.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/EmployeeModel.php";

class AttendanceController extends Controller
{
    private AttendanceView $view;
    private EmployeeModel $employee_model;

    public function __construct()
    {
        $this->view = new AttendanceView();
        $this->employee_model = new EmployeeModel();
    }

    public function index(): void
    {
        $this->view->index($this->employee_model->get_all());
    }

    public function add(): void
    {
        //TODO: сделать добавление посещаемости
    }
}
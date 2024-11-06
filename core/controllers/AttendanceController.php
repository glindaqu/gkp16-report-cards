<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/views/AttendanceView.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Controller.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/EmployeeModel.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/AttendanceModel.php";

class AttendanceController extends Controller
{
    private AttendanceView $view;
    private EmployeeModel $employee_model;
    private AttendanceModel $attendance_model;


    public function __construct()
    {
        $this->view = new AttendanceView();
        $this->employee_model = new EmployeeModel();
        $this->attendance_model = new AttendanceModel();
    }

    public function index(): void
    {
        $this->view->index($this->employee_model->get_all());
    }

    public function add(): void
    {
        $income_time = $_POST['income'];
        $outcome_time = $_POST['outcome'];
        $employee_id = $_POST['employee_id'];

        $date = date("Y-m-d");

        $income = DateTime::createFromFormat("Y-m-d H:i", "$date $income_time");
        $outcome = DateTime::createFromFormat("Y-m-d H:i", "$date $outcome_time");

        $this->attendance_model->add($employee_id, $income, $outcome);

        header("location: http://10.174.246.199/report/");
    }
}
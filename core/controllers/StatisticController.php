<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/views/StatisticView.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Controller.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/UserModel.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/AttendanceModel.php";

class StatisticController extends Controller
{
    private UserModel $user_model;
    private AttendanceModel $attendance_model;
    private StatisticView $view;

    public function __construct()
    {
        $this->view = new StatisticView();
        $this->user_model = new UserModel();
        $this->attendance_model = new AttendanceModel();
    }

    function index(array $params): void
    {
        $months = [
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь'
        ];
        $month = date("m");
        if (isset($params['month'])) 
        {
            $month = $params['month'];
        }
        $this->view->index(
            $this->user_model->get_users(), 
            $this->attendance_model->get_attendances($month), 
            $months,
            $month
        );
    }

    function edit(array $params): void
    {
        $row_id = $params['id'];
        $row = $this->attendance_model->get_attendances_by_id($row_id);
        $employee = $this->user_model->get_user_by_id($row['employee_id']);

        $name = $employee['lastname'] . " " . $employee['name'] . " " . $employee['patronymic'];
        $income_dt = DateTime::createFromFormat("Y-m-d H:i:s", $row['income']);
        $outcome_dt = DateTime::createFromFormat("Y-m-d H:i:s", $row['outcome']);

        $this->view->edit($name, $income_dt, $outcome_dt, $row);
    }

    function rewrite(): void
    {
        $income_time = $_POST['income'];
        $outcome_time = $_POST['outcome'];
        $attendance_id = $_POST['attendance_id'];

        $date = date("Y-m-d");

        $income = DateTime::createFromFormat("Y-m-d H:i", "$date $income_time");
        $outcome = DateTime::createFromFormat("Y-m-d H:i", "$date $outcome_time");

        $this->attendance_model->update($attendance_id, $income, $outcome);

        header("location: http://10.174.246.199/report/");
    }
}
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/views/StatisticView.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Controller.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/UserModel.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/AttendanceModel.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/logger/Logger.php";

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
        if (isset($params['month'])) {
            $month = $params['month'];
        }
        $role = $this->user_model->get_user_role($_COOKIE['user_id']);
        if ($role == "admin") {
            $this->view->admin(
                $this->user_model->get_users(),
                $this->attendance_model->get_attendances($month),
                $months,
                $month
            );
        } else if ($role == "employee") {
            $this->view->user(
                $this->attendance_model->get_attendances_by_user($_COOKIE['user_id'], $month),
                $months,
                $month
            );
        }
    }

    function edit(array $params): void
    {
        $row_id = $params['id'];
        $row = $this->attendance_model->get_attendances_by_id($row_id);
        $employee = $this->user_model->get_user_by_id($row['employee_id']);

        $name = $employee['lastname'] . " " . $employee['name'] . " " . $employee['patronymic'];
        $income_dt = DateTime::createFromFormat("Y-m-d H:i:s", $row['income']);
        $outcome_dt = DateTime::createFromFormat("Y-m-d H:i:s", $row['outcome']);

        $this->view->edit($name, $income_dt ?: null, $outcome_dt ?: null, $row);
    }

    function rewrite(): void
    {
        $income_time = $_POST['income'];
        $outcome_time = $_POST['outcome'];
        $attendance_id = $_POST['attendance_id'];
        $launch = $_POST['launch'];
        $date = $_POST['date'];

        $income = DateTime::createFromFormat("Y-m-d H:i", "$date $income_time");
        $outcome = DateTime::createFromFormat("Y-m-d H:i", "$date $outcome_time");

        $old_row = $this->attendance_model->get_attendances_by_id($attendance_id);
        $old_income = DateTime::createFromFormat("Y-m-d H:i:s", $old_row['income']);
        $old_outcome = DateTime::createFromFormat("Y-m-d H:i:s", $old_row['outcome']);
        $old_outcome_str = NULL;
        $old_income_str = NULL;
        if ($old_outcome) {
            $old_outcome_str = DateTime::createFromFormat("Y-m-d H:i:s", $old_row['outcome'])->format('H:i');
        }
        if ($old_income) {
            $old_income_str = DateTime::createFromFormat("Y-m-d H:i:s", $old_row['income'])->format('H:i');
        }
        $old_date = DateTime::createFromFormat("Y-m-d H:i:s", $old_row['income'])->format('Y-m-d');
        $old_launch = $old_row['launch'];

        $this->attendance_model->update(
            $attendance_id,
            $income ?: null,
            $outcome ?: null,
            $launch
        );
        Logger::Log(
            "(edit) Посещаемость обновлена. 
                                Income: old=$old_income_str, new=$income_time
                                Outcome: old=$old_outcome_str, new=$outcome_time 
                                Date: old=$old_date, new=$date
                                Launch: old=$old_launch, new=$launch"
        );
        header("location: http://10.174.246.199/report/");
    }
}
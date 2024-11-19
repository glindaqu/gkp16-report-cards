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
        $employee = $this->user_model->get_user_by_id($_COOKIE['user_id']);
        if ($employee['role'] == "admin") {
            $this->view->admin(
                $this->user_model->get_users(),
                $this->attendance_model->get_attendances($month),
                $months,
                $month
            );
        } else if ($employee['role'] == "employee") {
            $this->view->user(
                $this->attendance_model->get_attendances_by_user($_COOKIE['user_id'], $month),
                $months,
                $month,
                $employee
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

        $this->view->edit(
            $name, 
            $income_dt ?: null, 
            $outcome_dt ?: null, 
            $row, 
            $this->user_model->get_user_role($_COOKIE['user_id'])
        );
    }

    function rewrite(): void
    {
        $income_time = $_POST['income'];
        $outcome_time = $_POST['outcome'];
        $attendance_id = $_POST['attendance_id'];
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

        if (isset($_FILES['income_proof']) && $_FILES['income_proof']['error'] == 0) {
            move_uploaded_file($_FILES["income_proof"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '/report/temp/' . $_FILES["income_proof"]["name"]);
            $this->attendance_model->add_attendance_proof('income', $_FILES['income_proof']['name'], $old_row['id']);
        }

        if (isset($_FILES['outcome_proof']) && $_FILES['outcome_proof']['error'] == 0) {
            move_uploaded_file($_FILES["outcome_proof"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '/report/temp/' . $_FILES["outcome_proof"]["name"]);
            $this->attendance_model->add_attendance_proof('outcome', $_FILES['outcome_proof']['name'], $old_row['id']);
        }

        $this->attendance_model->update(
            $attendance_id,
            $income ?: null,
            $outcome ?: null
        );
        Logger::Log(
            "(edit) Посещаемость обновлена. 
                                Income: old=$old_income_str, new=$income_time
                                Outcome: old=$old_outcome_str, new=$outcome_time 
                                Date: old=$old_date, new=$date"
        );
        header("location: http://10.174.246.199/report/");
    }

    public function image(array $params): void {
        if (isset($params['name'])) {
            $this->view->image($params['name']);
        }
    }
}
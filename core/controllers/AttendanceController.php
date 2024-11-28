<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/views/AttendanceView.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Controller.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/AttendanceModel.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/UserModel.php";

class AttendanceController extends Controller
{
    private AttendanceView $view;
    private AttendanceModel $attendance_model;
    private UserModel $user_model;

    public function __construct()
    {
        $this->view = new AttendanceView();
        $this->attendance_model = new AttendanceModel();
        $this->user_model = new UserModel();
    }

    public function index(array $params): void
    {
        $role = $this->user_model->get_user_role($_COOKIE['user_id']);
        $user_id = $_COOKIE['user_id'];
        if (isset($params['user_id']) && $role == 'admin') {
            $user_id = $params['user_id'];
        }
        $this->view->index(
            $this->user_model->get_user_by_id($user_id),
            $role,
            isset($params['date']) ? $params['date'] : date('Y-m-d')
        );
    }

    public function add(array $params): void
    {
        $income_time = $_POST['income'];
        $outcome_time = $_POST['outcome'];
        $employee_id = $_POST['employee_id'];

        $date = date("Y-m-d");
        if (isset($_POST['date'])) {
            $date = $_POST['date'];
        } else if (isset($params['date'])) {
            $date = $params['date'];
        }

        if (isset($_FILES['income_proof']) && $_FILES['income_proof']['error'] == 0) {
            move_uploaded_file($_FILES['income_proof']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/report/temp/' . $_FILES['income_proof']['name']);
        }

        if (isset($_FILES['outcome_proof']) && $_FILES['outcome_proof']['error'] == 0) {
            move_uploaded_file($_FILES['outcome_proof']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/report/temp/' . $_FILES['outcome_proof']['name']);
        }

        $income = DateTime::createFromFormat("Y-m-d H:i", "$date $income_time");
        $outcome = DateTime::createFromFormat("Y-m-d H:i", "$date $outcome_time");
        $this->attendance_model->add_attendance(
            $employee_id,
            $income ? $income : NULL,
            $outcome ? $outcome : NULL,
            $_FILES['income_proof']['error'] == 0 ? $_FILES['income_proof']['name'] : null,
            $_FILES['outcome_proof']['error'] == 0 ? $_FILES['outcome_proof']['name'] : null,
            $_POST['desc']
        );
        Logger::Log(
            "(add) Посещаемость добавлена. 
                                Income: $income_time
                                Outcome: $outcome_time 
                                Target User: $employee_id
                                Date: $date"
        );
        $month = DateTime::createFromFormat('Y-m-d', $date)->format('m');
        header("location: http://10.174.246.199/report/statistic/index/month=$month");
    }
}

<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/views/AuthorizeView.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Controller.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/models/UserModel.php";

class AuthorizeController extends Controller
{
    private UserModel $user_model;
    private AuthorizeView $view;

    public function __construct()
    {
        $this->user_model = new UserModel();
        $this->view = new AuthorizeView();
    }

    public function auth(): void
    {
        $this->view->auth();
    }

    public function error(): void
    {
        $this->view->error();
    }

    public function check(): void
    {
        if (!isset($_POST['password']) || !isset($_POST['login'])) {
            $this->error();
            exit;
        }
        $login = $_POST['login'];
        $password = $_POST['password'];
        if (!($user = $this->user_model->get_user($login, $password))) {
            $this->error();
            exit;
        }
        setcookie(
            'user_id',
            $user['id'],
            time() + 3600 * 3,
            "/"
        );
        header("location: http://10.174.246.199/report/");
    }

    public static function has_auth(): int
    {
        if (isset($_COOKIE['user_id'])) {
            return 1;
        }
        return 0;
    }
}
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Model.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Database.php";

class UserModel extends Model {

    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function check_user(string $login, string $password): ?array {
        $response = $this->db->get_user_by_login_and_password($login, $password);
        if (isset($response['id'])) {
            return $response;
        }
        return null;
    }

    public function get_role(int $id): string {
        return $this->db->get_role_by_user_id($id);
    }

}
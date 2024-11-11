<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Model.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Database.php";

class UserModel extends Model
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function add_user(
        string $name,
        string $lastname,
        string $patronymic,
        string $login,
        string $role,
        string $password
    ): void {
        $this->db->insert_user($name, $lastname, $patronymic, $login, $role, $password);
    }

    public function get_users(): array
    {
        return $this->db->get_users();
    }

    public function get_user_by_id(int $id): array
    {
        return $this->db->get_user_by_id($id);
    }

    public function get_user_role(int $user_id): string
    {
        return $this->db->get_user_role($user_id);
    }

    public function check_user(string $login, string $password): bool
    {
        $response = $this->db->get_user($login, $password);
        if (isset($response['id'])) {
            return true;
        }
        return false;
    }

    public function get_user(string $login, string $password): ?array
    {
        $response = $this->db->get_user($login, $password);
        if (isset($response['id'])) {
            return $response;
        }
        return null;
    }
}
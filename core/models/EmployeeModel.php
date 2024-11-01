<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Model.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Database.php";

class EmployeeModel extends Model
{

    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function add(string $name, string $lastname, string $patronymic): void
    {
        $this->db->insert_employee($name, $lastname, $patronymic);
    }

    public function get_all(): array
    {
        return $this->db->get_employes();
    }
}
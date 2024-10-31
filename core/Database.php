<?php

class Database {
    private string $server_name = "localhost";
    private string $user = "report_user";
    private string $password = "report_password";
    private string $db_name = "report";

    private mysqli $db;

    public function __construct() {
        $this->db = new mysqli($this->server_name, $this->user, $this->password, $this->db_name);
    }

    public function insert_employee(string $name, string $lastname, string $patronymic): void {
        $this->db->query("INSERT INTO employee(name, lastname, patronymic) VALUES ('$name', '$lastname', '$patronymic')");
    }

    public function insert_attendance(DateTime $income, DateTime $outcome, int $employee_id): void {
        $outcome_str = $outcome->format('Y-m-d H:i:s');
        $income_str = $income->format('Y-m-d H:i:s');
        $this->db->query("INSERT INTO attendance(income, outcome, employee_id) VALUES ('$income_str', '$outcome_str', $employee_id)");
    }

    function get_employes(): array {
        $result = [];
        $response = $this->db->query("SELECT * FROM employee");
        while ($item = $response->fetch_assoc()) {
            $result[] = $item;
        }
        return $result;
    }

    function get_attendance(): array {
        $result = [];
        $response = $this->db->query("SELECT * FROM attendance");
        while ($item = $response->fetch_assoc()) {
            $result[] = $item;
        }
        return $result;
    }

    function get_attendance_by_employee(int $employee_id): array {
        $result = [];
        $response = $this->db->query("SELECT * FROM attendance WHERE employee_id = $employee_id");
        while ($item = $response->fetch_assoc()) {
            $result[] = $item;
        }
        return $result;
    }
}
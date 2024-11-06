<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Model.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Database.php";

class AttendanceModel extends Model {

    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function add(int $employee_id, DateTime $in, DateTime $out): void {
        $this->db->insert_attendance($in, $out, $employee_id);
    }

    public function get_all(): array {
        return $this->db->get_attendance();
    }

    public function get_by_employee(int $id): array {
        return $this->db->get_attendance_by_employee($id);
    }

    public function get_by_id(int $row_id): array {
        return $this->db->get_attendance_by_row_id($row_id);
    }

    function update(int $id, DateTime $in, DateTime $out): void {
        $this->db->update_attendance_by_id($in, $out, $id);
    }

}
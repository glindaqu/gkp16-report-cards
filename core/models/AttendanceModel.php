<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Model.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/Database.php";

class AttendanceModel extends Model
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function add_attendance(int $employee_id, ?DateTime $in, ?DateTime $out, ?string $icnome_proof, ?string $outcome_proof, string $desc): void
    {
        $this->db->insert_attendance($in, $out, $employee_id, $icnome_proof, $outcome_proof, $desc);
    }

    public function get_attendances(int $month, ?int $year): array
    {
        return $this->db->get_attendance($month, $year);
    }

    public function get_attendances_by_user(int $user_id, int $month): array
    {
        return $this->db->get_attendance_by_user($user_id, $month);
    }

    public function get_attendances_by_id(int $row_id): array
    {
        return $this->db->get_attendance_by_id($row_id);
    }

    function update(int $id, ?DateTime $in, ?DateTime $out, string $desc): void
    {
        $this->db->update_attendance_by_id($in, $out, $id, $desc);
    }

    function get_attendance_by_user_and_date(int $user_id, string $date): array
    {
        return $this->db->get_attendance_by_user_date($user_id, $date);
    }

    function add_attendance_proof(string $type, string $path, int $attendance_id): void
    {
        if ($type == 'income') {
            $this->db->add_income_proof($attendance_id, $path);
        } else if ($type == 'outcome') {
            $this->db->add_outcome_proof($attendance_id, $path);
        }
    }
}
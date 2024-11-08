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

    public function add_attendance(int $employee_id, DateTime $in, DateTime $out): void 
    {
        $this->db->insert_attendance($in, $out, $employee_id);
    }

    public function get_attendances(int $month): array 
    {
        return $this->db->get_attendance($month);
    }

    public function get_attendances_by_user(int $user_id): array 
    {
        return $this->db->get_attendance_by_user($user_id);
    }

    public function get_attendances_by_id(int $row_id): array 
    {
        return $this->db->get_attendance_by_id($row_id);
    }

    function update(int $id, DateTime $in, DateTime $out): void 
    {
        $this->db->update_attendance_by_id($in, $out, $id);
    }
}
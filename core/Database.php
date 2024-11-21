<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/config.php";

class Database
{
    private string $server_name = DB_SERVER_NAME;
    private string $user = DB_USER_NAME;
    private string $password = DB_USER_PASSWORD;
    private string $db_name = DB_DB_NAME;

    private mysqli $db;

    public function __construct()
    {
        $this->db = new mysqli($this->server_name, $this->user, $this->password, $this->db_name);
    }

    public function __destruct()
    {
        $this->db->close();
    }

    #region users
    public function insert_user(
        string $name,
        string $lastname,
        string $patronymic,
        string $login,
        string $role,
        string $password
    ): void {
        $this->db->query("INSERT INTO 
                            users(name, lastname, patronymic, login, role, password) 
                         VALUES ('$name', '$lastname', '$patronymic', '$login', '$role', '$password')");
    }

    public function get_users(): array
    {
        $result = [];
        $response = $this->db->query("SELECT * FROM users WHERE role != 'admin'");
        while ($response && $item = $response->fetch_assoc()) {
            $result[] = $item;
        }
        return $result;
    }

    public function get_user_role(int $user_id): string
    {
        return $this->db->query("SELECT role FROM users WHERE id=$user_id LIMIT 1")->fetch_assoc()['role'];
    }

    public function get_user_by_id(int $id): array
    {
        $response = $this->db->query("SELECT * FROM users WHERE id = $id");
        return $response->fetch_assoc();
    }

    public function get_user(string $login, string $password): array
    {
        return $this->db->query("SELECT * FROM users WHERE login='$login' AND password='$password' LIMIT 1")->fetch_assoc();
    }
    #endregion users

    #region attendance
    public function insert_attendance(?DateTime $income, ?DateTime $outcome, int $employee_id, ?string $icnome_proof, ?string $outcome_proof): void
    {
        $query = "INSERT INTO attendance(income, outcome, employee_id, ip_address, income_proof, outcome_proof) VALUES (";

        if ($income != null) {
            $d = $income->format("Y-m-d H:i:s");
            $query .= "'$d'" . ', ';
        } else {
            $query .= 'NULL, ';
        }

        if ($outcome != null) {
            $d = $outcome->format("Y-m-d H:i:s");
            $query .= "'$d'" . ', ';
        } else {
            $query .= 'NULL, ';
        }

        $addr = $_SERVER['REMOTE_ADDR'];
        $query .= $employee_id . ', ';
        $query .= "'$addr'" . ', ';

        if ($icnome_proof != null) {
            $query .= "'$icnome_proof'" . ', ';
        } else {
            $query .= 'NULL, ';
        }

        if ($outcome_proof != null) {
            $query .= "'$outcome_proof'" . ')';
        } else {
            $query .= 'NULL)';
        }
        $this->db->query($query);
    }

    public function get_attendance(int $month): array
    {
        $days_count = cal_days_in_month(CAL_GREGORIAN, $month, date("Y"));
        $year = date("Y");
        $result = [];
        $response = $this->db->query("SELECT * FROM attendance WHERE income BETWEEN '$year-$month-01' AND '$year-$month-$days_count'");
        while ($item = $response->fetch_assoc()) {
            $result[] = $item;
        }
        return $result;
    }

    public function get_attendance_by_user_date(int $user_id, string $date): array
    {
        $result = [];
        $response = $this->db->query("SELECT * FROM attendance WHERE employee_id=$user_id AND income BETWEEN '$date 00:00:00' AND '$date 23:59:59' LIMIT 1");
        while ($response && $item = $response->fetch_assoc()) {
            $result[] = $item;
        }
        return $result;
    }

    public function get_attendance_by_user(int $user_id, int $month): array
    {
        $days_count = cal_days_in_month(CAL_GREGORIAN, $month, date("Y"));
        $year = date("Y");
        $result = [];
        $response = $this->db->query("SELECT * FROM attendance WHERE employee_id = $user_id AND income BETWEEN '$year-$month-01' AND '$year-$month-$days_count'");
        while ($response && $item = $response->fetch_assoc()) {
            $result[] = $item;
        }
        return $result;
    }

    public function get_attendance_by_id(int $id): array
    {
        $response = $this->db->query("SELECT * FROM attendance WHERE id = $id");
        return $response->fetch_assoc();
    }

    public function update_attendance_by_id(?DateTime $income, ?DateTime $outcome, int $attendance_id): void
    {
        $outcome_str = $outcome ? $outcome->format('Y-m-d H:i:s') : NULL;
        $income_str = $income ? $income->format('Y-m-d H:i:s') : NULL;
        if ($income_str == NULL && $outcome_str == NULL) {
            $this->db->query("UPDATE attendance SET income=NULL, outcome=NULL WHERE id=$attendance_id");
        } else if ($income_str == NULL) {
            $this->db->query("UPDATE attendance SET income=NULL, outcome='$outcome_str' WHERE id=$attendance_id");
        } else if ($outcome_str == NULL) {
            $this->db->query("UPDATE attendance SET income='$income_str', outcome=NULL WHERE id=$attendance_id");
        } else {
            $this->db->query("UPDATE attendance SET income='$income_str', outcome='$outcome_str' WHERE id=$attendance_id");
        }
    }

    public function add_income_proof(int $id, string $path): void
    {
        $this->db->query("UPDATE attendance SET income_proof='$path' WHERE id=$id");
    }

    public function add_outcome_proof(int $id, string $path): void
    {
        $this->db->query("UPDATE attendance SET outcome_proof='$path' WHERE id=$id");
    }
    #endregion attendance
}
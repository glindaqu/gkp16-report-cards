<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/View.php";

class StatisticView extends View
{
    public function admin(array $employes, array $attendance, array $months, int $current_month, int $current_year): void
    {
        $role = "admin";
        ob_start();
        require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/statistic/admin.php";
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    public function user(array $attendance, array $months, int $current_month, array $employee): void
    {
        ob_start();
        require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/statistic/user.php";
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    public function edit(string $name, ?DateTime $income_dt, ?DateTime $outcome_dt, array $row, string $role): void
    {
        ob_start();
        require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/statistic/edit.php";
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    public function image(string $name): void {
        ob_start();
        require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/statistic/image.php";
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
}
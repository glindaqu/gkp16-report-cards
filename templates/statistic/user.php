<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/report/static/css/statistic.css">
    <title>Сотрудник</title>
</head>

<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/report/templates/header.php"); ?>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/core/utils/Translate.php"; ?>

    <?php $days_count = cal_days_in_month(CAL_GREGORIAN, $current_month, date("Y")); ?>

    <div class="content">
        <div class="month_pick_wrapper">
            <select class="month_pick">
                <?php foreach ($months as $id => $month) { ?>
                    <option value="<?= $id ?>" <?= $id == $current_month ? 'selected' : '' ?>><?= $month ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="employee_stat_container margin-10">
            <?php
            $today = date("d");
            $month = date("m");
            for ($i = 1; $i <= $days_count; $i++) {
                $index = array_search($i, array_map(function ($item): string {
                    return DateTime::createFromFormat("Y-m-d H:i:s", $item['income'])->format("d");
                }, $attendance));
                $attendance_id = '';
                if (is_numeric($index)) {
                    $attendance_id = $attendance[$index]['id'];
                }
                ?>
                <div class="employee_stat_container__item <?= $attendance[$index]['description'] != null ? 'core_highlight' : '' ?> <?= $today == $i && $month == $current_month ? 'today' : '' ?>"
                    id="<?= $attendance_id ?>">
                    <div class="employee_stat_container__item_date">
                        <?=
                            $i . ', ' . TranslateUtils::translate_weekday(DateTime::createFromFormat(
                                "Y-m-d",
                                date("Y") . "-$current_month-$i"
                            )->format("D"))
                            ?>
                    </div>
                    <div class="employee_stat_container__item_content">
                        <?php
                        if (is_numeric($index)) {
                            $income_dt = DateTime::createFromFormat("Y-m-d H:i:s", $attendance[$index]['income']);
                            $outcome_dt = DateTime::createFromFormat("Y-m-d H:i:s", $attendance[$index]['outcome']);
                            $interval = NULL;
                            $time = strtotime($attendance[$index]['income']);
                            $time = $time + ($employee['launch'] * 60);
                            $date = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s", $time));
                            if ($income_dt && $outcome_dt) {
                                $interval = $outcome_dt->diff($date);
                            }
                            ?>
                            <div class="time_section">
                                <div class="income"><?= $income_dt ? $income_dt->format("H:i") : 'NULL' ?> </div>
                                <div class="outcome"><?= $outcome_dt ? $outcome_dt->format("H:i") : 'NULL' ?></div>
                            </div>
                            <?= $interval ? sprintf("%02d:%02d", $interval->h, $interval->i) : 'NULL' ?>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/report/templates/footer.php"); ?>

    <script>
        document.querySelector(".month_pick").addEventListener("change", () => {
            let e = document.querySelector(".month_pick");
            let value = e.options[e.selectedIndex].value;
            window.location = "http://10.174.246.199/report/statistic/index/month=" + value;
        });
        document.querySelectorAll(".employee_stat_container__item").forEach(item => {
            item.addEventListener("click", element => {
                if (item.id != "") {
                    window.location = "http://10.174.246.199/report/statistic/edit/id=" + item.id;
                } else {
                    let date = new Date();
                    let e = document.querySelector(".month_pick");
                    let month = e.options[e.selectedIndex].value;
                    let day = item;
                    window.location = `http://10.174.246.199/report/attendance/index/date=${date.getFullYear()}-${month}-${item.childNodes[1].innerText.split(', ')[0]}`;
                }
            });
        });
    </script>
</body>

</html>
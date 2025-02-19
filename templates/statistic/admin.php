<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика</title>
    <link rel="stylesheet" href="/report/static/css/statistic.css">
</head>

<body>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/header.php"; ?>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/core/utils/Translate.php"; ?>
    <?php $days_count = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year); ?>

    <div class="date_desc hide">qqq</div>

    <div class="container">
        <div class="content">
            <select class="month_pick">
                <?php foreach ($months as $id => $month) { ?>
                    <option value="<?= $id ?>" <?= $id == $current_month ? 'selected' : '' ?>><?= $month ?></option>
                <?php } ?>
            </select>
            <select class="year_pick">
                <?php for ($i = 2024; $i <= date("Y"); $i++) { ?>
                    <option value="<?= $i ?>" <?= $i == $current_year ? 'selected' : '' ?>><?= $i ?></option>
                <?php } ?>
            </select>

            <div class="table_wrapper">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <?php
                            for ($i = 1; $i <= $days_count; $i++) {
                                $formatted_date = DateTime::createFromFormat("Y-m-d", "$current_year-$current_month-$i");
                                ?>
                                <th class="center">
                                    <?=
                                        $i . ', ' . TranslateUtils::translate_weekday($formatted_date->format("D"))
                                        ?>
                                </th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employes as $employee) { ?>
                            <tr>
                                <?php
                                $name = $employee['lastname'] . " " . $employee['name'] . " " . $employee['patronymic'];
                                $attendance_by_employee = array_filter($attendance, function ($item) use ($employee): bool {
                                    return $item['employee_id'] == $employee['id'];
                                });
                                ?>
                                <th class="name"><?= $name ?></th>
                                <?php for ($i = 1; $i <= $days_count; $i++) { ?>
                                    <?php
                                    $index = array_search($i, array_map(function ($item): string {
                                        $key = ($item['outcome'] == NULL) ? 'income' : 'outcome';
                                        return DateTime::createFromFormat("Y-m-d m:H:i", $item[$key])->format("d");
                                    }, $attendance_by_employee));
                                    $div_id = '';
                                    if (is_numeric($index) && isset(($attendance_by_employee[$index]['id']))) {
                                        $div_id = $attendance_by_employee[$index]['id'];
                                    }
                                    $formatted_date = DateTime::createFromFormat("Y-m-d", "$current_year-$current_month-$i")->format('Y-m-d');
                                    ?>
                                    <td class="content_row__date <?= $attendance_by_employee[$index]['description'] == null ? '' : 'core_highlight' ?> <?= $formatted_date == date('Y-m-d') ? 'current' : '' ?>"
                                        id="<?= $div_id ?>" data-user_id="<?= $employee['id'] ?>"
                                        data-desc="<?= $attendance_by_employee[$index]['description'] ?>"
                                        data-date="<?= $formatted_date ?>">
                                        <?php
                                        if (is_numeric($index)) {
                                            $income_dt = DateTime::createFromFormat("Y-m-d H:i:s", $attendance_by_employee[$index]['income']);
                                            $outcome_dt = DateTime::createFromFormat("Y-m-d H:i:s", $attendance_by_employee[$index]['outcome']);
                                            $interval = NULL;
                                            $time = strtotime($attendance_by_employee[$index]['income']);
                                            $time += ($employee['launch'] * 60);
                                            if ($income_dt && $outcome_dt) {
                                                $interval = $outcome_dt->diff(DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s", $time)));
                                            }
                                            ?>
                                            <div class="time_section">
                                                <div class="income"><?= $income_dt ? $income_dt->format("H:i") : "NULL" ?> </div>
                                                <div class="outcome"><?= $outcome_dt ? $outcome_dt->format("H:i") : "NULL" ?></div>
                                            </div>
                                            <?= $interval != null ? sprintf("%02d:%02d", $interval->h, $interval->i) : "NULL" ?>
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/footer.php"; ?>

    <script>
        const menu = document.querySelector(".menu");
        const date = new Date();
        const day = date.getDate();

        document.querySelectorAll('.content_row__date').forEach(el => {
            el.addEventListener('click', () => {
                if (el.id != '') {
                    window.location.replace(`http://10.174.246.199/report/statistic/edit/id=${el.id}`);
                } else {
                    window.location.replace(`http://10.174.246.199/report/attendance/index/user_id=${el.dataset.user_id}&date=${el.dataset.date}`);
                }
            });
        });

        document.querySelector(".month_pick").addEventListener("change", () => {
            let m = document.querySelector(".month_pick");
            let y = document.querySelector(".year_pick");
            let month = m.options[m.selectedIndex].value;
            let year = y.options[y.selectedIndex].value;
            window.location = `http://10.174.246.199/report/statistic/index/year=${year}&month=${month}`;
        });

        document.querySelector(".year_pick").addEventListener("change", () => {
            let m = document.querySelector(".month_pick");
            let y = document.querySelector(".year_pick");
            let month = m.options[m.selectedIndex].value;
            let year = y.options[y.selectedIndex].value;
            window.location = `http://10.174.246.199/report/statistic/index/year=${year}&month=${month}`;
        });

        const given_month = window.location.toString().split('=')[1];

        if (given_month == date.getMonth() + 1 || given_month == null) {
            document.querySelector('.table_wrapper').scrollTo({
                top: 0,
                left: 106 * (day - date.getDay()),
                behavior: "smooth",
            });
        }

        const descBlock = document.querySelector('.date_desc');

        document.querySelectorAll('.core_highlight').forEach(element => {
            element.addEventListener('mouseenter', event => {
                descBlock.classList.remove('hide');
                descBlock.style.top = event.clientY + 'px';
                descBlock.style.left = event.clientX + 'px';
                descBlock.innerHTML = element.dataset.desc;
            });
            element.addEventListener('mouseleave', () => {
                descBlock.classList.add('hide');
            })
        });
    </script>
</body>

</html>
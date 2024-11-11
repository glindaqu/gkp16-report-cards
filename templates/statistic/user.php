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

    <?php $days_count = cal_days_in_month(CAL_GREGORIAN, $current_month, date("Y")); ?>

    <div class="content">
        <select class="month_pick">
            <?php foreach ($months as $id => $month) { ?>
                <option value="<?= $id ?>" <?= $id == $current_month ? 'selected' : '' ?>><?= $month ?></option>
            <?php } ?>
        </select>
        <div class="employee_stat_container margin-10">
            <?php
            for ($i = 1; $i <= $days_count; $i++) {
                $index = array_search($i, array_map(function ($item): string {
                    return DateTime::createFromFormat("Y-m-d H:i:s", $item['income'])->format("d");
                }, $attendance));
                ?>
                <div class="employee_stat_container__item">
                    <div class="employee_stat_container__item_date">
                        <?= $i ?>
                    </div>
                    <div class="employee_stat_container__item_content">
                        <?php
                        if (is_numeric($index)) {
                            $income_dt = DateTime::createFromFormat("Y-m-d H:i:s", $attendance[$index]['income']);
                            $outcome_dt = DateTime::createFromFormat("Y-m-d H:i:s", $attendance[$index]['outcome']);
                            $interval = $outcome_dt->diff($income_dt);
                            ?>
                            <div class="time_section">
                                <div class="income"><?= $income_dt->format("H:i") ?> </div>
                                <div class="outcome"><?= $outcome_dt->format("H:i") ?></div>
                            </div>
                            <?= sprintf("%02d:%02d", $interval->h, $interval->i) ?>
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
            console.log(value);
        });
    </script>
</body>

</html>
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
    <?php $days_count = cal_days_in_month(CAL_GREGORIAN, $current_month, date("Y")); ?>

    <div class="container">
        <div class="menu hidden">
            <div class="item">Редактировать</div>
        </div>
        <div class="content">
            <select class="month_pick">
                <?php foreach ($months as $id => $month) { ?>
                    <option value="<?= $id ?>" <?= $id == $current_month ? 'selected' : '' ?>><?= $month ?></option>
                <?php } ?>
            </select>
            <div class="table_body">
                <div class="content_header">
                    <?php for ($i = 1; $i <= $days_count; $i++) { ?>
                        <div class="content_row__date"><?= $i ?></div>
                    <?php } ?>
                </div>
                <?php foreach ($employes as $employee) { ?>
                    <div class="content_row">
                        <?php
                        $name = $employee['lastname'] . " " . $employee['name'] . " " . $employee['patronymic'];
                        $attendance_by_employee = array_filter($attendance, function ($item) use ($employee): bool {
                            return $item['employee_id'] == $employee['id'];
                        });
                        ?>
                        <div class="content_row__name">
                            <div class="name"><?= $name ?></div>
                        </div>
                        <?php for ($i = 1; $i <= $days_count; $i++) { ?>
                            <?php
                            $index = array_search($i, array_map(function ($item): string {
                                return DateTime::createFromFormat("Y-m-d H:i:s", $item['income'])->format("d");
                            }, $attendance_by_employee));
                            $div_id = '';
                            if (is_numeric($index) && isset(($attendance_by_employee[$index]['id']))) {
                                $div_id = $attendance_by_employee[$index]['id'];
                            }
                            ?>
                            <div class="content_row__date" id="<?= $div_id ?>">
                                <?php
                                if (is_numeric($index)) {
                                    $income_dt = DateTime::createFromFormat("Y-m-d H:i:s", $attendance_by_employee[$index]['income']);
                                    $outcome_dt = DateTime::createFromFormat("Y-m-d H:i:s", $attendance_by_employee[$index]['outcome']);
                                    $interval = NULL;
                                    if ($income_dt && $outcome_dt) {
                                        $interval = $outcome_dt->diff($income_dt);
                                    }
                                    ?>
                                    <div class="time_section">
                                        <div class="income"><?= $income_dt ? $income_dt->format("H:i") : "NULL" ?> </div>
                                        <div class="outcome"><?= $outcome_dt ? $outcome_dt->format("H:i") : "NULL" ?></div>
                                    </div>
                                    <?= $interval ? sprintf("%02d:%02d", $interval->h, $interval->i) : "NULL" ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/footer.php"; ?>

    <script>
        const menu = document.querySelector(".menu");

        let lastClickedId = 0;

        document.addEventListener('contextmenu', e => {
            console.log(e.target);
            if (e.target.className != 'content_row__date' || e.target.id == '') {
                menu.classList.add("hidden");
                return;
            }
            drawContextMenu({ x: e.clientX, y: e.clientY });
            lastClickedId = e.target.id;
            e.preventDefault();
        });

        document.addEventListener('click', () => { menu.classList.add("hidden"); })

        const drawContextMenu = pos => {
            menu.classList.remove("hidden");
            menu.setAttribute("style", `top: ${pos.y}px; left: ${pos.x}px;`);
        };

        document.querySelector(".item").addEventListener("click", () => {
            window.location.replace(`http://10.174.246.199/report/statistic/edit/id=${lastClickedId}`)
        });

        document.querySelector(".month_pick").addEventListener("change", () => {
            let e = document.querySelector(".month_pick");
            let value = e.options[e.selectedIndex].value;
            window.location = "http://10.174.246.199/report/statistic/index/month=" + value;
        });
    </script>
</body>

</html>
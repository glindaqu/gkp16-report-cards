<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изменение записи</title>
    <link rel="stylesheet" href="/report/static/css/attendance.css">
</head>

<body>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/header.php"; ?>

    <form action="/report/statistic/rewrite" method="post">
        <input name="attendance_id" value="<?= $row['id'] ?>" style="display: none" />
        <label>
            Имя сотрудника
            <select id="employee_pick">
                <option value="<?= $row['employee_id'] ?>"> <?= $name ?> </option>
            </select>
        </label>
        <label>
            Время прихода
            <input type="time" name="income" id="income" value="<?= $income_dt ? $income_dt->format("H:i") : '' ?>" />
        </label>
        <label>
            Время ухода
            <input type="time" name="outcome" id="outcome" value="<?= $outcome_dt ? $outcome_dt->format("H:i") : '' ?>" />
        </label>
        <input type="text" name="date" style="display: none;" value="<?= $income_dt->format("Y-m-d") ?>">
        <input type="submit" value="Сохранить" />
    </form>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/footer.php"; ?>

</body>

</html>
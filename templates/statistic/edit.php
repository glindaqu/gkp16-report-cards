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

    <form action="/report/attendance/add" method="post">
        <label>
            Имя сотрудника
            <select name="employee_id" id="employee_pick">
                <option value="<?= $row['employee_id'] ?>"> <?= $name ?> </option>
            </select>
        </label>
        <label>
            Время прихода
            <input type="time" name="income" id="income" value="<?= $income_dt->format("H:i") ?>" />
        </label>
        <label>
            Время ухода
            <input type="time" name="outcome" id="outcome" value="<?= $outcome_dt->format("H:i") ?>" />
        </label>
        <input type="submit" value="Сохранить" />
    </form>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/footer.php"; ?>

</body>

</html>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить посещаемость</title>
    <link rel="stylesheet" href="/report/static/css/attendance.css">
</head>

<body>

    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/header.php";
    $name = $employee['lastname'] . " " . $employee['name'] . " " . $employee['patronymic'];
    ?>
    <form action="/report/attendance/add" method="post">
        <label>
            Имя сотрудника
            <select name="employee_id" id="employee_pick">
                <option value="<?= $employee['id'] ?>"> <?= $name ?> </option>
            </select>
        </label>
        <label>
            Время прихода
            <input type="time" name="income" id="income" />
        </label>
        <label>
            Время ухода
            <input type="time" name="outcome" id="outcome" />
        </label>
        <input type="submit" value="Добавить" />
    </form>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/footer.php"; ?>

</body>

</html>
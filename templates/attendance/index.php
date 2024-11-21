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
    <form action="/report/attendance/add/date=<?= $date ?>" method="post" enctype="multipart/form-data">
        <label>
            Имя сотрудника
            <select name="employee_id" id="employee_pick">
                <option value="<?= $employee['id'] ?>"> <?= $name ?> </option>
            </select>
        </label>
        <label>
            Время прихода
            <input type="time" name="income" id="income" />
            <?php if ($role == 'admin') { ?>
                <input type="file" name="income_proof">
                <?php if ($row['income_proof'] != '') { ?>
                    <a href="http://10.174.246.199/report/statistic/image/name=<?= $row['income_proof'] ?>">Сохраненное фото</a>
                <?php } ?>
            <?php } ?>
        </label>
        <label>
            Время ухода
            <input type="time" name="outcome" id="outcome" />
            <?php if ($role == 'admin') { ?>
                <input type="file" name="outcome_proof">
                <?php if ($row['outcome_proof'] != '') { ?>
                    <a href="http://10.174.246.199/report/statistic/image/name=<?= $row['outcome_proof'] ?>">Сохраненное фото</a>
                <?php } ?>
            <?php } ?>
        </label>
        <input type="submit" value="Добавить" />
    </form>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/footer.php"; ?>

</body>

</html>
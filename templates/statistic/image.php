<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр</title>
    <link rel="stylesheet" href="/report/static/css/image.css">
</head>

<body>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/header.php"; ?>

    <img src="http://10.174.246.199/images/<?= $name ?>">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/report/templates/footer.php"; ?>

</body>

</html>
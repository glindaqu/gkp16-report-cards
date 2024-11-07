<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="/report/static/css/style.css">
    <link rel="stylesheet" href="/report/static/css/auth.css">
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="title">Report</div>
            <form action="/report/authorize/check" method="post">
                <input type="text" placeholder="Логин" name="login">
                <input type="password" placeholder="Пароль" name="password">
                <input type="submit" value="Войти">
            </form>
        </div>
    </div>
</body>

</html>
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/report/core/logger/config.php";

class Logger
{
    private static string $file_path = LOG_FILE_PATH;

    public static function Log(string $message): void
    {
        $dt = new DateTime("now", new DateTimeZone('Asia/Novosibirsk'));
        $date = $dt->format('d.m.Y, H:i:s');
        file_put_contents(
            Logger::$file_path,
            "[$date] $message
                                User_Id={$_COOKIE['user_id']}
                                IP={$_SERVER['REMOTE_ADDR']}\n",
            FILE_APPEND
        );
    }

}
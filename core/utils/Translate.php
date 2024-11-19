<?php

class TranslateUtils
{
    public static function translate_weekday(string $eng): string
    {
        switch ($eng) {
            case 'Mon':
                return 'Пн';
            case 'Tue':
                return 'Вт';
            case 'Wed':
                return 'Ср';
            case 'Thu':
                return 'Чт';
            case 'Fri':
                return 'Пт';
            case 'Sat':
                return 'Сб';
            case 'Sun':
                return 'Вс';
            default:
                return '';
        }
    }
}
<?php


namespace App\Tools;


class Tool
{
    public static function code(string $id) {
        return trans('code.' . $id);
    }

    public static function message(string $id) {
        return trans('message.' . $id);
    }

    public static function filterEmoji($string) {
        $string = preg_replace_callback('/./u', function (array $match) {
           return strlen($match[0]) >= 4 ? '' : $match[0];
        }, $string);

        return $string;
    }
}
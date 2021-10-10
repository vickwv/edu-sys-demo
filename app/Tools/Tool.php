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
}
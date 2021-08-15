<?php

declare(strict_types=1);

namespace App\Traits;

trait EnumTrait
{
    public static function toArray()
    {
        $array = [];

        foreach (self::$title as $const => $title) {
            $array[] = $const;
        }

        return $array;
    }

    public static function toJson()
    {
        $array = [];

        foreach (self::$title as $const => $title) {
            $array[] = $const;
        }

        return json_encode($array);
    }

    public static function title($const)
    {
        $array = [];

        if (array_key_exists($const, self::$title)) {
            return self::$title[$const];
        }

        return '';
    }

    public static function titleJson()
    {
        return json_encode(self::$title);
    }
}

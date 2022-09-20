<?php

declare(strict_types=1);

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class Tbl
{
    private function __construct()
    {
    }

    /**
     * @var array|string[]
     */
    private static array $TABLE_MAP = [];

    public static function table($class) : string
    {
        if (! array_key_exists($class, self::$TABLE_MAP)) {
            /** @var Model $instance */
            $instance = (new $class);
            self::$TABLE_MAP[$class] = $instance->getTable();
        }

        return self::$TABLE_MAP[$class];
    }

    public static function column($table, $column) : string
    {
        if (self::isClass($table)) {
            $table = self::table($table);
        }

        return $table.'.'.$column;
    }

    public static function isClass($table) : bool
    {
        return Str::contains($table, '\\') && class_exists($table);
    }
}

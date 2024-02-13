<?php

namespace App\Services;

class MemoizationService
{
    private static $_memoizable = [];

    public static function memoized(string $key, callable $callback, $group = 'default')
    {
        if (!isset(static::$_memoizable[$group][$key])) {
            $value = $callback();
            if (function_exists('debugbar')) {
                // debugbar()->addMessage('Memoizing - Group: '.$group.', Key: '.$key.', value:'.json_encode($value));
            }
            static::$_memoizable[$group][$key] = $value;
        }

        return static::$_memoizable[$group][$key];
    }
}

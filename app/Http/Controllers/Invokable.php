<?php

namespace App\Http\Controllers;

trait Invokable {
    public static $classNameSpace = '\\'.self::class;
    public static function __getClassNameSpace() {
        return '\\'.self::class;
    }
}

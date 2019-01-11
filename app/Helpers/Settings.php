<?php

namespace App\Helpers;

class Settings
{
    public $data = [];
    private static $instance;

    private function __construct()
    {
    }
    private function __clone()
    {
    }
    private function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (null === static::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function get($key)
    {
        $s = self::getInstance();
        return $s->data[$key];
    }

    public static function set($key, $value)
    {
        $s = self::getInstance();
        $s->data[$key] = $value;
    }

    public static function all()
    {
        $s = self::getInstance();
        return $s->data;
    }
}

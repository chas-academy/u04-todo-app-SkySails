<?php

class Account extends Controller
{
    public static function doSomething()
    {
        print_r(self::query("SELECT * FROM users"));
    }
}

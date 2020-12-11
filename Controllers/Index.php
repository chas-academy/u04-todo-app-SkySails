<?php

class Index extends Controller
{
    public static function RenderView($params)
    {
        self::middleware();
        echo Twig::render("Index", $params);
    }
}

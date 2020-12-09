<?php

class Controller extends DataBase
{
    public static function CreateView($viewName)
    {
        require_once "./Views/$viewName.php";
    }
}

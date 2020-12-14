<?php

class Controller extends DataBase
{

    public static function middleware()
    {
        session_start();
        $signed_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
        if (!$signed_in) {
            header("location: login");
            exit;
        }
    }

    public static function CreateView($viewName)
    {
        require_once "./Views/$viewName.php";
    }
}

<?php

class Login extends Controller
{
    public static function RenderView()
    {
        session_start();
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("location: /");
            exit;
        }

        echo Twig::render("Login");
    }
}

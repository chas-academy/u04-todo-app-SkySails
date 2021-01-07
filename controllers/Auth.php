<?php

// Auth controller. Renders authentication routes and handles redirects.
class Auth extends Controller
{
    public static function RenderLogin()
    {
        session_start();

        // If user is already logged in, redirect to dashbaord
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("location: /");
            exit;
        }

        echo Twig::render("Login");
    }

    public static function RenderRegister()
    {
        // If user is already logged in, redirect to dashbaord
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("location: /");
            exit;
        }

        echo Twig::render("Register");
    }

}

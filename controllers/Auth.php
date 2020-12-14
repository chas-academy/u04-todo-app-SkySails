<?php

class Auth extends Controller
{
    public static function RenderView($viewtype)
    {
        if ($viewtype == "login") {
            session_start();

            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                header("location: /");
                exit;
            }

            echo Twig::render("Login");
        } else {

            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                header("location: /");
                exit;
            }

            echo Twig::render("Register");
        }
    }

}

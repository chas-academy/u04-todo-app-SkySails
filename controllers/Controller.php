<?php

// Main controller class. All other controllers extend this class.
class Controller extends Database
{

    // Middleware is used to make sure that unquthenticated requests to protected pages are redirected to the signin page.
    public static function middleware()
    {
        session_start();
        $signed_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true; // Check if auth session is available
        if (!$signed_in) {
            // If no session is available, redirect to login using header
            header("location: login");
            exit;
        }
    }
}

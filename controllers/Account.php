<?php

// Account controller. Fetches and renders account data.
class Account extends Controller
{
    public static function RenderView($id = null)
    {
        self::middleware(); // Check for auth and redirect if none found
        $id = $id or $id = $_SESSION["id"];
        $account_data = UserModel::getProfile($id); // Get acount data from DB using id

        echo Twig::render("Account", $account_data); // Render content to user
    }
}

<?php

class Account extends Controller
{
    public static function RenderView($id = null)
    {
        self::middleware();
        $id = $id or $id = $_SESSION["id"];
        $account_data = UserModel::getProfile($id);

        echo Twig::render("Account", $account_data);
    }
}

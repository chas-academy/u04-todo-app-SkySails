<?php

require __DIR__ . '/../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$GLOBALS['errors'] = [
    "not_found" => "No user was found with the entered email address.",
    "db_err" => "Something went wrong. Please try again later.",
    "invalid_details" => "Invalid password.",
    "already_registered" => "A user with the entered email address already exists.",
];

class Twig
{
    private static $twig = null;

    public static function render(string $page, array $site_content = array())
    {
        if (!isset(self::$twig)) {
            $loader = new FilesystemLoader([$_SERVER['DOCUMENT_ROOT'] . '/Views', $_SERVER['DOCUMENT_ROOT'] . '/Templates']);
            self::$twig = new Environment($loader);
            self::$twig->addGlobal("route", $_SERVER["REQUEST_URI"]);
            if (isset($_SESSION)) {
                self::$twig->addGlobal("session", $_SESSION);
            }
            if (isset($_GET["err"])) {
                self::$twig->addGlobal("error", $GLOBALS["errors"][$_GET["err"]]);
            }
        }

        $markup = self::$twig->render($page . ".html.twig", $site_content);

        return $markup;
    }
}

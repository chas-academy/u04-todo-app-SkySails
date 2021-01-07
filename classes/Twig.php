<?php

require __DIR__ . '/../vendor/autoload.php';

// Load Twig essentials
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Detailed descriptions of each error code, used to display errors to user
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
            $loader = new FilesystemLoader([$_SERVER['DOCUMENT_ROOT'] . '/Views', $_SERVER['DOCUMENT_ROOT'] . '/Templates']); // Add paths to twig files
            self::$twig = new Environment($loader);
            self::$twig->addGlobal("route", $_SERVER["REQUEST_URI"]); // Add rendered route name as global variable (usable in all twig pages)
            if (isset($_SESSION)) {
                self::$twig->addGlobal("session", $_SESSION); // If user signed in, add session as global variable (usable in all twig pages)
            }
            if (isset($_GET["err"])) {
                self::$twig->addGlobal("error", $GLOBALS["errors"][$_GET["err"]]); // If the url params contain an error code, add the error description to a global variable (usable in all twig pages)
            }
        }

        $markup = self::$twig->render($page . ".html.twig", $site_content); // Renders a twig template with the provided name, using any provided parameters

        return $markup; // Returns rendered HTML
    }
}

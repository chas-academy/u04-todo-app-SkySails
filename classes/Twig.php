<?php

require __DIR__ . '\..\vendor\autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
    private static $twig = null;

    public static function render(string $page, array $site_content = array())
    {
        if (!isset(self::$twig)) {
            $loader = new FilesystemLoader([$_SERVER['DOCUMENT_ROOT'] . '/Views', $_SERVER['DOCUMENT_ROOT'] . '/Templates']);
            self::$twig = new Environment($loader);
            self::$twig->addGlobal("route", $_SERVER["REQUEST_URI"]);
        }

        $markup = self::$twig->render($page . ".html.twig", $site_content);

        return $markup;
    }
}

<?php

// Index controller, fetches and renders data for the index page (dashboard)
class Index extends Controller
{
    public static function RenderView($type = "full")
    {
        self::middleware(); // Check for auth and redirect if none found

        $data = TodoModel::getListsWithTodos(); // Get array containing all lists and their todos

        // Render whole page by default. In template mode, only the lists and their todos are rendered (for AJAX)
        if ($type == "template") {
            echo Twig::render("todos", ["todolists" => $data]);
        } else {
            echo Twig::render("Index", ["todolists" => $data]);
        }
    }
}

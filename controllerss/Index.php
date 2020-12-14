<?php

class Index extends Controller
{
    public static function RenderView($type = "full")
    {
        self::middleware();

        $data = TodoModel::getListsWithTodos();

        if ($type == "template") {
            echo Twig::render("todos", ["todolists" => $data]);
        } else {
            echo Twig::render("Index", ["todolists" => $data]);
        }
    }
}

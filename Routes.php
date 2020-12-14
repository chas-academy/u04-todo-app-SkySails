<?php

//?###################
//?  Base routes    ##
//?###################

Route::add('/', function () {
    Index::RenderView();
});

Route::add('/renderajax', function () {
    Index::RenderView("template");
});

Route::add('/account', function () {
    Account::RenderView();
});

//?###################
//?  Auth routes    ##
//?###################

Route::add('/register', function () {
    Auth::RenderView("register");
});

Route::add('/register', function () {
    UserModel::registerUser($_POST);
}, "post");

Route::add('/login', function () {
    Auth::RenderView("login");
});

Route::add('/login', function () {
    UserModel::signinUser($_POST);
}, "post");

//?###################
//?   API routes    ##
//?###################

// Get all lists
Route::add('/api/lists', function () {
    session_start();
    echo "Get all lists" . $_SESSION["id"];
});

// Create list
Route::add('/api/lists', function () {
    TodoModel::addList($_POST["name"]);
}, "post");

// Get list with id
Route::add('/api/lists/:id', function ($list_id) {
    echo "Get list with id: " . $list_id;
});

// Delete list with id
Route::add('/api/lists/:id', function ($list_id) {
    TodoModel::deleteList($list_id);
}, "delete");

// Delete completed todos in list with id
Route::add('/api/lists/:id', function ($list_id) {
    TodoModel::deleteAllDoneInList($list_id);
}, "purge");

// Complete all todos in list with id
Route::add('/api/lists/:id', function ($list_id) {
    TodoModel::completeAllInList($list_id);
}, "patch");

// Get items
Route::add('/api/items', function () {
    echo "Get all items";
});

// Add item
Route::add('/api/items', function () {
    // echo "Add item with title: " . $_POST["title"];
    TodoModel::addTodo($_POST);
}, "post");

// Get item with id
Route::add('/api/items/:id', function ($item_id) {
    echo "Get item with id: " . $item_id;
});

// Update item with id
Route::add('/api/items/:id', function ($item_id) {
    parse_str(file_get_contents('php://input'), $_PATCH);

    TodoModel::updateTodo(intval($item_id), $_PATCH);
}, "patch");

// Delete item with id
Route::add('/api/items/:id', function ($item_id) {
    TodoModel::deleteTodo($item_id);
}, "delete");

Route::pathNotFound(function () {
    echo <<<HTML
        <h1>Oopsie! Not found :(</h1>
HTML;
});

Route::run("/");

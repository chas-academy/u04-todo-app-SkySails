<?php

//?###################
//?  Base routes    ##
//?###################

Route::add('/', function () {
    Index::RenderView(); // Renders index (Dashboard) page
});

Route::add('/renderajax', function () {
    Index::RenderView("template"); // Renders ONLY the lists and their content (used for AJAX requests)
});

Route::add('/account', function () {
    Account::RenderView(); // Renders a view showing account details
});

Route::pathNotFound(function () { // Very creative 404 page
    echo <<<HTML
        <h1>Oopsie! Not found :(</h1>
HTML;
});

//?###################
//?  Auth routes    ##
//?###################

Route::add('/register', function () {
    Auth::RenderRegister(); // Renders an authentication page with a registration form
});

Route::add('/register', function () {
    UserModel::registerUser($_POST); // Handles POST requests to the registration screen (used to handle registration)
}, "post");

Route::add('/login', function () {
    Auth::RenderLogin("login"); // Renders an authentication page with a login form
});

Route::add('/login', function () {
    UserModel::signinUser($_POST); // Handles POST requests to the login screen (used to handle signin)
}, "post");

//?###################
//?   API routes    ##
//?###################

// Not finished, since it is out of scope for this assignment. The below is just a POC showing the capability of my MVC framework

// Create list
Route::add('/api/lists', function () {
    TodoModel::addList($_POST["name"]);
}, "post");

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

// Get todos from list
Route::add('/api/:id/todo', function ($list_id) {
    TodoModel::getListsWithTodos($list_id);
});

// Add todo
Route::add('/api/todo', function () {
    TodoModel::addTodo($_POST);
}, "post");

// Get todo with id
Route::add('/api/todo/:id', function ($todo_id) {
    TodoModel::getTodo($todo_id);
});

// Update todo with id
Route::add('/api/todo/:id', function ($todo_id) {
    parse_str(file_get_contents('php://input'), $_PATCH); // Parse contents of PATCH request

    TodoModel::updateTodo(intval($todo_id), $_PATCH);
}, "patch");

// Delete todo with id
Route::add('/api/todo/:id', function ($todo_id) {
    TodoModel::deleteTodo($todo_id);
}, "delete");

// Execute/add all above routes using "/" as basepath.
Route::run("/");

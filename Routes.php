<?php

Route::add('/', function () {
    Index::RenderView(["data" => "Test"]);
});

Route::add('/account', function () {
    Account::RenderView();
});

// Route::add('/account/:id', function ($id) {
//     Account::RenderView($id);
// });

Route::add('/register', function () {
    Register::RenderView();
});

Route::add('/register', function () {
    UserModel::registerUser($_POST);
}, "post");

Route::add('/login', function () {
    Login::RenderView();
});

Route::add('/login', function () {
    UserModel::signinUser($_POST);
}, "post");

Route::pathNotFound(function () {
    echo <<<HTML
        <h1>Oopsie! Not found :(</h1>
HTML;
});

Route::run("/");

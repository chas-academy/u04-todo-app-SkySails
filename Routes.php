<?php

Route::add('/', function () {
    Index::CreateView("Index");
});

Route::add('/todos', function () {
    Todos::CreateView("Todos");
});

Route::add('/account', function () {
    echo <<<HTML
        <h1>Accounts</h1>
HTML;
});

Route::add('/account/:id', function ($id) {
    $html = <<<HTML
        <h1>Account</h1>
HTML;
    $account_data = UserModel::getProfile($id);
    var_dump($account_data);
    foreach ($account_data as $key => $value) {
        echo $key . " => " . $value . "<br/>";
    }
});

Route::add('/register', function () {
    echo <<<HTML
        <h1>Register</h1>
        <form method="post" style="display: flex; flex-direction: column; align-items: flex-start;">
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
            <label for="name">Email</label>
            <input type="email" name="email" id="email">
            <label for="name">Password</label>
            <input type="password" name="password" id="password">
            <button>Register</button>
        </form>
HTML;
});

Route::add('/register', function () {
    echo 'Hey! The form has been sent:<br/>';
    UserModel::registerUser($_POST);
}, "post");

Route::pathNotFound(function () {
    echo <<<HTML
        <h1>Oopsie! Not found :(</h1>
HTML;
});

Route::run("/");

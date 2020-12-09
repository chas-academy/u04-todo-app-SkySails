<?php

Route::set('index.php', function () {
    Index::CreateView("Index");
});

Route::set('todos', function () {
    Todos::CreateView("Todos");
});
Route::set('admin', function () {
    Admin::CreateView("Admin");
});

Route::set('account', function () {
    Account::CreateView("Account");
});

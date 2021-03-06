<p align="center">
  <img src="https://user-images.githubusercontent.com/46646495/101921189-013c5e00-3bcd-11eb-99b9-f30e90f8604e.png">
</p>

# u04-todo-app

TodoApp is a todo app (duh) that lets you easily manage and create todo lists and cards. The UI is simple but beautiful and provides all the elements you'd expect from a product of its kind. Feel like a boss while checking off one checkbox after another!

## Todo

- [x] MVC framework with routing capabilities
- [x] Database interactions using models
- [x] Authentication using PHP Sessions
- [x] Controller middleware for protected routes
- [x] Include final SQL file in repository
- [x] Actual todo functionality

## Screenshots

![The index page](https://user-images.githubusercontent.com/46646495/102143800-cd7b6580-3e64-11eb-8719-f0d7969f6a8b.png)
![The login page](https://user-images.githubusercontent.com/46646495/102143877-e421bc80-3e64-11eb-834b-0c701f7d148d.png)

## Tech

This assignment is based on a custom MVC framework and provides the ability to sign in, register, and use the application as an authenticated user. During development, MAMP was used to host the backend.

| Type            | Name   |
| --------------- | ------ |
| Server          | Apache |
| Database        | MySQL  |
| Template Engine | Twig   |

## Running the project

To run this project on a local server of your choice, you need to set up your environment.

**Prerequisites:** [`Composer`](https://getcomposer.org/)

### Project configuration

#### Config files

The project depends on valid config parameters for the database. These can be found in [`/classes/dbconfig.ini`](https://github.com/chas-academy/u04-todo-app-SkySails/blob/master/classes/dbconfig.ini) and should be set to match your environment.

#### Composer

Since this project depends on [Twig](https://twig.symfony.com/) to render its pages, composer is needed to get the project up and running. Running

```bash
$ composer install
```

in the root directory of this repo will install `twig` and its dependencies in the `/vendor` folder.

### Database

The database you intend to use needs to be formatted using the SQL file provided under [`/environment`](https://github.com/chas-academy/u04-todo-app-SkySails/tree/master/environment).

1. Open a database administration interface of your choice (Adminer, phpMyAdmin, Navicat etc.)
2. Find the `Import` option in the interface and open it
3. Import the SQL file from this repository

### Server (Apache)

To be able to serve clean routes, the server needs to parse the URI of every request and send it to the index file. This is done using the [`.htaccess`](https://github.com/chas-academy/u04-todo-app-SkySails/blob/master/.htaccess) file. Make sure that your server is able to read this correctly.

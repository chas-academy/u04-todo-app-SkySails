<p align="center">
  <img src="https://user-images.githubusercontent.com/46646495/101920713-6b083800-3bcc-11eb-816f-c9d40d9b68d9.png">
</p>

# u04-todo-app

TodoApp is a todo app (duh) that lets you easily manage and create todo lists and cards. The UI is simple but beautiful and provides all the elements you'd expect from a product of its kind. Feel like a boss while checking off one checkbox after another!

## Todo

- [x] MVC framework with routing capabilities
- [x] Database interactions using models
- [x] Authentication using PHP Sessions
- [x] Controller middleware for protected routes
- [ ] Actual todo functionality

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

You can confirm that the database was set up correctly by running the following query towards it:

```sql
SELECT * FROM users WHERE id = test
```

### Server (Apache)

To be able to serve clean routes, the server needs to parse the URI of every request and send it to the index file. This is done using the [`.htaccess`](https://github.com/chas-academy/u04-todo-app-SkySails/blob/master/.htaccess) file. Make sure that your server is able to read this correctly.

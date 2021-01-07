<?php declare (strict_types = 1);

class UserModel extends Database
{
    // Get user data from user with id
    public static function getProfile(string $id)
    {
        $data = self::query('SELECT * FROM users WHERE id = ?', array($id));
        return $data[0];
    }

    // Register user with provided params
    public static function registerUser(array $params)
    {
        if (isset($params)) {
            extract($params);

            if ($name !== "" && $email !== "" && $password !== '') {
                try {
                    $id = uniqid(); // Generate unique (as can be) id for user
                    $pw_hash = password_hash($password, PASSWORD_BCRYPT); // Encrypt password and output hash (contains hashed password AND salt)
                    self::query('INSERT INTO users (id, name, email, pw_hash) VALUES (?, ?, ?, ?)', array($id, $name, $email, $pw_hash)); // Store user data

                    session_start(); // Start a user session

                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $name;

                    // Redirect user to welcome page
                    header("location: /");
                } catch (PDOException $e) {
                    header("location: /register?err=already_registered");
                }
            } else {
                header("location: /register?err=invalid_details");
            }
        }

    }

    // Sign in user with provided params
    public static function signinUser($params)
    {
        extract($params);

        // If required parameters are available (Uns)
        if ($password !== "" && $email !== "") {

            try {
                $user = self::query('SELECT * FROM users WHERE email = ?', array($email));

                if (isset($user[0])) {
                    $user = $user[0];

                    if (password_verify($password, $user["pw_hash"])) {

                        // Password is correct, start a new session
                        session_start();

                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $user["id"];
                        $_SESSION["username"] = $user["name"];

                        // Redirect user to welcome page
                        header("location: /");
                    } else {
                        header("location: /login?err=invalid_details");
                    }
                } else {
                    header("location: /login?err=not_found");
                }
            } catch (PDOException $e) {
                header("location: /login?err=db_err");
            }

        } else {
            header("location: /login?err=invalid_details");
        }

    }
}

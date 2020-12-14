<?php declare (strict_types = 1);

class UserModel extends Database
{
    public static function getProfile(string $id)
    {
        $data = self::query('SELECT * FROM users WHERE id = ?', array($id));
        return $data[0];
    }

    public static function registerUser(array $params)
    {
        if (isset($params)) {
            extract($params);

            if ($name !== "" && $email !== "" && $password !== '') {
                try {
                    $id = uniqid();
                    $pw_hash = password_hash($password, PASSWORD_BCRYPT);
                    self::query('INSERT INTO users (id, name, email, pw_hash) VALUES (?, ?, ?, ?)', array($id, $name, $email, $pw_hash));

                    session_start();

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
    public static function signinUser($params)
    {
        extract($params);
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

        }

    }
}

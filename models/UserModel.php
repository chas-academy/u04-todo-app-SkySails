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
            } else {
                echo "Something went wrong.";
            }
        }

    }
    public static function signinUser($params)
    {
        extract($params);
        if ($password !== "" && $email !== "") {

            $user = self::query('SELECT * FROM users WHERE email = ?', array($email))[0];

            if (password_verify($password, $user["pw_hash"])) {
                // Password is correct, start a new session
                session_start();

                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user["id"];
                $_SESSION["username"] = $user["name"];

                // Redirect user to welcome page
                header("location: /");
            }

        }

    }
}

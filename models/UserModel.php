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
            $id = uniqid();
            $pw_hash = password_hash($password, PASSWORD_BCRYPT);

            self::query('INSERT INTO users (id, name, email, pw_hash) VALUES (?, ?, ?, ?)', array($id, $name, $email, $pw_hash));
        }

    }
}

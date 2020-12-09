<?php

class UserModel extends Database
{
    public function getProfile($id)
    {
        $data = self::query('SELECT * FROM users WHERE id = ?', array($id));
        return $data;
    }
}

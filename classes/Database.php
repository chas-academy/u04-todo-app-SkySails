<?php

class Database
{

    private static $pdo = null;

    private static function connect()
    {
        if (!isset($pdo)) {
            $ini = parse_ini_file("dbconfig.ini");
            $pdo = new PDO("mysql:host={$ini["host"]};dbname={$ini["dbname"]};charset=utf8", $ini["user"], $ini["password"]);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $pdo;
    }

    public static function query($query, $params = array())
    {
        $statement = self::connect()->prepare($query);
        $statement->execute($params);
        if (explode(' ', $query)[0] == 'SELECT') {
            $data = $statement->fetchAll();
            return $data;
        }
    }
}

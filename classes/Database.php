<?php

class Database
{

    private static $pdo = null;

    private static function connect()
    {
        if (!isset(self::$pdo)) {
            $ini = parse_ini_file("dbconfig.ini");
            self::$pdo = new PDO("mysql:host={$ini["host"]};dbname={$ini["dbname"]};charset=utf8", $ini["user"], $ini["password"]);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
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

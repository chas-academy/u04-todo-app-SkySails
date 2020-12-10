<?php

class Database
{

    private static $pdo = null;

    private static function connect()
    {
        if (!isset(self::$pdo)) {
            $ini = parse_ini_file("dbconfig.ini");

            try {
                self::$pdo = new PDO("mysql:host={$ini["host"]};dbname={$ini["dbname"]};charset=utf8", $ini["user"], $ini["password"]);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
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

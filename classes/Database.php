<?php declare (strict_types = 1);

// Database class. Responsible for the connection and communication with the database.
class Database
{

    private static $pdo = null;

    // Function that establishes connection, if a connection is not already available
    private static function connect()
    {
        if (!isset(self::$pdo)) {
            $ini = parse_ini_file("dbconfig.ini"); // Reads database config from external file

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

    // Queries the database using provided SQL query and parameters
    public static function query(string $query, array $params = array())
    {
        $statement = self::connect()->prepare($query);
        $statement->execute($params); // Bind parameters to query

        // IF query contains SELECT, return data. Works in this small-scale project, but for more complex queries this would be obselete
        // since some queries update/modify data using information from other tables, returning nothing despite any SELECT.
        if (explode(' ', $query)[0] == 'SELECT') {
            $data = $statement->fetchAll();
            return $data;
        }
    }
}

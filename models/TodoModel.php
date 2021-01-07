<?php declare (strict_types = 1);

// Todo model. Responsible for interacting with the database when changing, adding and deleting todos.
class TodoModel extends Database
{
    public static function getTodo(int $id)
    {
        session_start();

        // Check if auth session is available
        if (isset($_SESSION["id"])) {
            $data = self::query('SELECT * FROM todos WHERE id = ?', array($id));
            return (array) $data[0];
        } else {
            echo "No user logged in";
        }
    }

    // Get all lists (and their todos) for authenticated user
    public static function getListsWithTodos()
    {
        session_start();

        // Check if auth session is available
        if (isset($_SESSION["id"])) {

            // Join "lists" and "todos" table, create list containing list_name, list_id, (todo) id, created_by, title, description, status, created_at
            $data = self::query('SELECT lists.NAME AS list_name, lists.id AS list_id, todos.id, todos.created_by, todos.title, todos.description, todos.status, todos.created_at FROM lists LEFT JOIN todos ON lists.id = todos.list_id WHERE lists.created_by = ? ', array($_SESSION["id"]));

            // Reduce above mentioned data and order them by list. Create one object for each list, with all todos associated to said list as children.
            $reduced_data = array_reduce($data, function ($acc, $curr) {
                $list_id = $curr["list_id"];
                $list_name = $curr["list_name"];

                unset($curr["list_id"]);
                unset($curr["list_name"]);

                $acc[$list_id]["name"] = $list_name;
                if (isset($curr["id"])) {
                    $acc[$list_id]["todos"][] = $curr;
                }

                return $acc;
            }, []);

            return $reduced_data;
        } else {
            echo "No user logged in";
        }
    }

    // Add a todo with specified parameters
    public static function addTodo(array $params)
    {
        session_start();

        if (isset($params)) {
            extract($params);
            session_start();

            // Check if all required params are specified, including auth
            if (isset($title) && $title !== "" && isset($_SESSION) && isset($list_id)) {
                try {
                    self::query('INSERT INTO todos (title, description, created_by, list_id) VALUES (?, ?, ?, ?)', array($title, $description, $_SESSION["id"], $list_id));
                    http_response_code(200);
                    echo json_encode(["success" => "true", "message" => "Todo added successfully!"]);
                } catch (PDOException $e) {
                    http_response_code(500);
                    echo json_encode(["success" => "false", "message" => $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["success" => "false", "message" => "Insufficient parameters", "params" => $params, "validSession" => isset($_SESSION)]);
            }
        }
    }

    // Update a todo with id using specified parameters
    public static function updateTodo(int $id, array $params)
    {
        session_start();

        if (isset($params) && isset($id)) {
            extract($params);

            // Check if all required params are specified, including auth
            if (isset($title) && $title !== "" && isset($description) && isset($status) && $status !== "") {
                try {
                    self::query('UPDATE todos SET `title` = ?, `description` = ?,  `status` = ? WHERE id = ?', array($title, $description, $status, $id));
                    http_response_code(200);
                    echo json_encode(["success" => "true", "message" => "Todo updated successfully!", "params" => $params]);
                } catch (PDOException $e) {
                    http_response_code(500);
                    echo json_encode(["success" => "false", "message" => $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["success" => "false", "message" => "Insufficient parameters", "params" => $params]);
            }
        }
    }

    // Delete a todo with id using specified parameters
    public static function deleteTodo(string $id)
    {
        session_start();

        if (isset($id) && $id !== "") {
            try {
                self::query('DELETE from todos WHERE id = ?', array($id));
                http_response_code(200);
                echo json_encode(["success" => "true", "message" => "Todo deleted successfully! " . $id]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(["success" => "false", "message" => $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["success" => "false", "message" => "Insufficient parameters"]);
        }
    }

    // Add a list using specified parameters
    public static function addList(string $name)
    {
        session_start();

        if (isset($name) && $name !== "" && isset($_SESSION)) {
            try {
                self::query('INSERT INTO lists (name, created_by) VALUES (?, ?)', array($name, $_SESSION["id"]));
                http_response_code(200);
                echo json_encode(["success" => "true", "message" => "List added successfully!"]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(["success" => "false", "message" => $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["success" => "false", "message" => "Insufficient parameters", "validSession" => isset($_SESSION)]);
        }
    }

    // Delete a list with id using specified parameters
    public static function deleteList(string $id)
    {
        session_start();

        if (isset($id) && $id !== "" && isset($_SESSION)) {
            try {
                self::query('DELETE FROM lists WHERE id = ?', array($id));
                http_response_code(200);
                echo json_encode(["success" => "true", "message" => "List deleted successfully!"]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(["success" => "false", "message" => $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["success" => "false", "message" => "Insufficient parameters", "validSession" => isset($_SESSION)]);
        }
    }

    // Complete all todos in list with id
    public static function completeAllInList(string $id)
    {
        if (isset($id) && $id !== "") {
            try {
                self::query('UPDATE todos SET `status` = 1 WHERE list_id = ?', array($id));
                http_response_code(200);
                echo json_encode(["success" => "true", "message" => "Todos updated successfully!"]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(["success" => "false", "message" => $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["success" => "false", "message" => "Insufficient parameters"]);
        }
    }

    // Delete all completed todos in list with id
    public static function deleteAllDoneInList(string $id)
    {
        session_start();

        if (isset($id) && $id !== "" && isset($_SESSION)) {
            try {
                self::query('DELETE FROM todos WHERE `status` = "1" AND `list_id` = ?', array($id));
                http_response_code(200);
                echo json_encode(["success" => "true", "message" => "Completed todos deleted successfully!"]);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(["success" => "false", "message" => $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["success" => "false", "message" => "Insufficient parameters", "validSession" => isset($_SESSION)]);
        }
    }
}

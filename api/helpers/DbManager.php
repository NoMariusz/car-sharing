<?php
class DbManager
{
    private static function make_connection()
    {
        global $host, $user, $passwd, $db;
        $mysqli = mysqli_connect($host, $user, $passwd, $db);
        return $mysqli;
    }

    static function make_querry($query)
    {
        $mysqli =  self::make_connection();

        $res = $mysqli->query($query);
        if (!$res) return ["success" => false, "msg" => $mysqli->error];;
        $arr = $res->fetch_all(MYSQLI_ASSOC);

        // close connection
        $mysqli->close();

        return ["success" => true, "msg" => $arr];
    }

    static function make_safe_querry($query, $types = null, $params = null)
    {
        $mysqli = self::make_connection();

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param($types, ...$params);

        // if execute not succeed
        if (!$stmt->execute()) return ["success" => false, "msg" => $mysqli->error];

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // close statement
        $stmt->close();

        // close connection
        $mysqli->close();

        return ["success" => true, "msg" => $result];
    }

    static function make_no_result_querry($query)
    {
        $response = ["success" => false, "msg" => ""];

        $mysqli =  self::make_connection();
        $res = $mysqli->query($query);

        if (!$res) $response["msg"] = $mysqli->error;
        $response["success"] = $res;

        // close connection
        $mysqli->close();

        return $response;
    }

    static function make_safe_no_result_querry($query, $types = null, $params = null)
    {
        $mysqli = self::make_connection();

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param($types, ...$params);

        // if execute not succeed
        if (!$stmt->execute()) return ["success" => false, "msg" => $mysqli->error];

        // close statement
        $stmt->close();

        // close connection
        $mysqli->close();

        return ["success" => true, "msg" => "done"];
    }

    static function make_insert_id_querry($query)
    {
        $mysqli = self::make_connection();
        $res = $mysqli->query($query);

        if (!$res) return ["success" => false, "msg" => $mysqli->error];

        // get insert id
        $result = mysqli_insert_id($mysqli);

        // close connection
        $mysqli->close();

        return ["success" => true, "msg" => $result];
    }

    static function make_safe_insert_id_querry(
        $query,
        $types = null,
        $params = null,
        $defaultMysqli = null
    ) {
        if ($defaultMysqli == null) {
            $mysqli = self::make_connection();
        } else {
            $mysqli = $defaultMysqli;
        }

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param($types, ...$params);

        // if execute not succeed
        if (!$stmt->execute()) {
            return ["success" => false, "msg" => $mysqli->error];
        }

        // get insert id
        $result =  mysqli_insert_id($mysqli);

        // close statement
        $stmt->close();

        if ($defaultMysqli == null) {
            // close connection
            $mysqli->close();
        }

        return ["success" => true, "result" => $result];
    }
}

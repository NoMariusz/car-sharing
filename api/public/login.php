<?php
include("../includes.php");

$response = array('result' => false);

function main()
{
    global $response;

    $headers = apache_request_headers();

    if (isset($headers['login'], $headers['password'])) {
        $login = $headers['login'];
        $password = urldecode($headers['password']);

        $result = DbManager::make_safe_querry(
            "SELECT * FROM `users` WHERE login = ? AND password = sha1(?);",
            "ss",
            [$login, $password]
        );

        if ($result["success"] === false) {
            $response["msg"] = "Bad query";
            return;
        }

        $data = $result["msg"];
        if (count($data) > 0) {
            if (!$data[0]['is_activated']) {
                $response["msg"] = "This account isn't activated";
                return;
            }

            session_start();
            $_SESSION["uid"] = $data[0]['user_id'];
            $response = array('result' => true);
            return;
        }

        $response["msg"] = "Can't find user with that login and password";
    }
}

main();
echo json_encode($response);

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
            "SELECT user_id FROM `users` WHERE login = ? AND password = sha1(?);",
            "ss",
            [$login, $password]
        );

        if ($result === false) {
            $response["msg"] = "Bad query";
            return;
        }

        if (count($result) > 0) {
            session_start();
            $_SESSION["uid"] = $result[0]['user_id'];

            $response = array('result' => true);
        } else {
            $response["msg"] = "Can't find user with that login and password";
        }
    }
}

main();
echo json_encode($response);

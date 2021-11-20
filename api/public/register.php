<?php
include("../includes.php");

function main()
{
    $response = array('result' => false);

    $headers = apache_request_headers();

    if (isset($headers['Login'], $headers['Password'])) {
        $login = $headers['Login'];
        $password =  urldecode($headers['Password']);
        $email = $headers['email'];

        $dbResult = DbManager::make_safe_insert_id_querry(
            "INSERT INTO `users`(`login`, `password`, `email`) VALUES (?,SHA1(?),?)",
            "sss",
            [$login, $password, $email]
        );

        if ($dbResult["success"]) {
            $response = array('result' => true);
        } else {
            $response["msg"] = $dbResult["msg"];
        }
    }

    echo json_encode($response);
}

main();

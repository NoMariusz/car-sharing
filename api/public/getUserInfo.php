<?php
include("../includes.php");

function main()
{
    $response = array('logged' => false, 'user' => null);


    session_start();
    if (isset($_SESSION["uid"])) {
        $id = $_SESSION["uid"];

        $data = DbManager::make_querry("SELECT * FROM users WHERE user_id = $id");
        $response['user'] = $data["msg"][0];
        $response['logged'] = true;
    }

    echo json_encode($response);
}

main();

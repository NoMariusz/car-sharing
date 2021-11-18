<?php
include("../includes.php");
$response = array('success' => false);

function main()
{
    global $response;

    session_start();
    if (isset($_SESSION["uid"], $_GET["user_id"], $_GET["active"], $_GET["role_id"])) {
        $user_id = intval($_GET["user_id"]);
        $active = intval($_GET["active"]);
        $role = intval($_GET["role_id"]);

        $response = DbManager::make_safe_no_result_querry("UPDATE users SET role_id=?, is_activated=? WHERE user_id = ?", "iii", [$role, $active, $user_id]);
    }
}

main();

echo json_encode($response);

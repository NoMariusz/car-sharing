<?php
include("../includes.php");
$response = array('success' => false);

function main()
{
    global $response;

    session_start();
    if (isset($_SESSION["uid"], $_GET["reservation_id"])) {
        $reservation_id = $_GET["reservation_id"];

        $response = DbManager::make_safe_no_result_querry(
            "DELETE FROM `reservations` WHERE id = ?",
            "i",
            [$reservation_id]
        );
    }
}

main();

echo json_encode($response);

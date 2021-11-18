<?php
include("../includes.php");
$response = array('success' => false);

function main()
{
    global $response;

    session_start();
    if (isset($_SESSION["uid"], $_GET["car_id"], $_GET["start_date"], $_GET["end_date"])) {
        $car_id = $_GET["car_id"];
        $sDate = $_GET["start_date"];
        $eDate = $_GET["end_date"];
        $user_id = $_SESSION["uid"];

        $response = DbManager::make_safe_insert_id_querry(
            "INSERT INTO `reservations`(`car_id`, `user_id`, `start_date`, `end_date`) VALUES (?, ?, ? ,?);",
            "iiss",
            [$car_id, $user_id, $sDate, $eDate]
        );
    }
}

main();

echo json_encode($response);

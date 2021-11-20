<?php
include("../includes.php");
$response = array('success' => false);

function main()
{
    global $response, $ENDED_RESERVATION_STATUS_ID;

    session_start();
    if (isset($_SESSION["uid"], $_GET["reservation_id"])) {
        $reservation_id = $_GET["reservation_id"];

        $response = DbManager::make_safe_no_result_querry(
            "UPDATE `reservations` SET `reservation_status_id`=?, return_date=current_timestamp() WHERE id=?",
            "ii",
            [$ENDED_RESERVATION_STATUS_ID, $reservation_id]
        );
        check_if_held_too_long($reservation_id);
    }
}

function check_if_held_too_long($reservation_id)
{
    global $response;
    $res = DbManager::make_safe_no_result_querry(
        "UPDATE reservations
        INNER JOIN users ON users.user_id = reservations.user_id
        SET users.reputation= CASE
           WHEN reservations.end_date < reservations.return_date THEN users.reputation-1
           ELSE users.reputation
        END
        WHERE reservations.id = ?;",
        "i",
        [$reservation_id]
    );
    if (!$res["success"]) {
        $response["msg"] = $response["msg"] . "\ncheck_if_held_too_long() - " . $res["msg"];
    }
}

main();

echo json_encode($response);

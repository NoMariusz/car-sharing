<?php
include("../includes.php");
$response = array('success' => false);

function main()
{
    global $response;

    session_start();
    if (isset($_SESSION["uid"], $_GET["res_id"], $_GET["res_status_id"], $_GET["start_date"], $_GET["end_date"])) {
        $res_id = intval($_GET["res_id"]);
        $res_status_id = intval($_GET["res_status_id"]);
        $start_date = $_GET["start_date"];
        $end_date = $_GET["end_date"];

        if (if_try_to_double_active($res_id, $res_status_id)) {
            $response['msg'] = "Car for that request are having other active request at that moment";
            return;
        }

        $response = DbManager::make_safe_no_result_querry(
            "UPDATE reservations SET reservation_status_id=?, start_date=?, end_date=? WHERE id = ?",
            "issi",
            [$res_status_id, $start_date, $end_date, $res_id]
        );
    }
}

function if_try_to_double_active($res_id, $status_id)
{
    global $ACTIVE_RESERVATION_STATUS_ID;
    // if is reservation having status active for car, then can't set other res for that car as active
    $res = DbManager::make_querry("SELECT Count(r.id) > 0 as result
    FROM `reservations` as r 
    WHERE r.car_id = (
        SELECT car_id from reservations WHERE id = $res_id
        ) AND r.`reservation_status_id` = $ACTIVE_RESERVATION_STATUS_ID AND id <> $res_id;");
    return $res["msg"][0]["result"] && $status_id == $ACTIVE_RESERVATION_STATUS_ID;
}

main();

echo json_encode($response);

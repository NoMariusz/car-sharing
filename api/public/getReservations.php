<?php
include("../includes.php");
$response = array('success' => false, 'data' => null);

session_start();
if (isset($_SESSION["uid"])) {
    $uid = $_SESSION["uid"];
    $res = DbManager::make_querry("SELECT r.id, r.reservation_status_id, r.start_date, r.end_date, r.return_date, rs.name as status, cars.id as car_id, cars.color, ct.mark, ct.model, ct.year
    FROM `reservations` as r
    INNER JOIN reservation_statuses as rs ON r.reservation_status_id = rs.id
    INNER JOIN cars ON cars.id = r.car_id
    INNER JOIN car_types as ct ON cars.car_type_id = ct.id
    WHERE r.user_id = $uid");
    $response = $res;

    if ($res["success"]) {
        $response['success'] = true;
        $response['data'] = $res["msg"];
    }
}

echo json_encode($response);

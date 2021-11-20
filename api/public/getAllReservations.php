<?php
include("../includes.php");
$response = array('success' => false, 'data' => null);

session_start();
if (isset($_SESSION["uid"])) {
    $uid = $_SESSION["uid"];
    $res = DbManager::make_querry("(SELECT r.id, r.reservation_status_id, rs.name as status_name, r.start_date, r.end_date, r.return_date, cars.id as car_id, cars.color, ct.mark, ct.model, ct.year, u.user_id, u.login, u.reputation, 0 as cancelled
    FROM `reservations` as r
    INNER JOIN reservation_statuses as rs ON r.reservation_status_id = rs.id
    INNER JOIN cars ON cars.id = r.car_id
    INNER JOIN car_types as ct ON cars.car_type_id = ct.id
    INNER JOIN users as u ON u.user_id = r.user_id)
    UNION
    (SELECT r.id, r.reservation_status_id, rs.name as status_name, r.start_date, r.end_date, r.return_date, cars.id as car_id, cars.color, ct.mark, ct.model, ct.year, u.user_id, u.login, u.reputation, 1 as cancelled
    FROM `cancelled_reservations` as r
    INNER JOIN reservation_statuses as rs ON r.reservation_status_id = rs.id
    INNER JOIN cars ON cars.id = r.car_id
    INNER JOIN car_types as ct ON cars.car_type_id = ct.id
    INNER JOIN users as u ON u.user_id = r.user_id);");
    $response = $res;

    if ($res["success"]) {
        $response['success'] = true;
        $response['data'] = $res["msg"];
    }
}

echo json_encode($response);

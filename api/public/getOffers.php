<?php
include("../includes.php");
$response = array('success' => false, 'data' => null);

$res = DbManager::make_querry("SELECT cars.id, cars.color, car_types.mark, car_types.model, car_types.year, IFNULL(r.cnt, 0) as reservations_count, IFNULL(r_active.is_reserved, false) as is_reserved
FROM cars
INNER JOIN car_types ON car_types.id = cars.car_type_id
LEFT JOIN (
SELECT r.car_id, count(1) cnt from reservations as r WHERE r.reservation_status_id = 1 GROUP BY r.car_id
) as r ON r.car_id = cars.id
LEFT JOIN (
SELECT r.car_id ,true is_reserved from reservations as r WHERE r.reservation_status_id = 2
) as r_active ON r_active.car_id = cars.id;");
$response = $res;
if ($res["success"]) {
    $response['success'] = true;
    $response['data'] = $res["msg"];
}

echo json_encode($response);

<?php
include("../includes.php");
$response = array('success' => false, 'data' => null);

$res = DbManager::make_querry("SELECT * FROM users;");
if ($res["success"]) {
    $response['success'] = true;
    $response['data'] = $res["msg"];
}

echo json_encode($response);

<?php
include("../includes.php");
$response = array('success' => false, 'data' => null);

session_start();
if (isset($_SESSION["uid"])) {
    $response = DbManager::make_no_result_querry("DROP EVENT IF EXISTS time_accelerate;");
}

echo json_encode($response);

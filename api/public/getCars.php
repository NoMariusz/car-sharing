<?php
include("../includes.php");
$response = array('success' => false, 'data' => null);

$response = DbManager::make_querry("SELECT * from car_types;");

echo json_encode($response);

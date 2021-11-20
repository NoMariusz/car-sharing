<?php
include("../includes.php");
$response = array('success' => false, 'data' => null);

session_start();
if (isset($_SESSION["uid"])) {
    $response = DbManager::make_no_result_querry("CREATE EVENT 
    IF NOT EXISTS
    time_accelerate
    ON SCHEDULE EVERY 1 SECOND
    STARTS CURRENT_TIMESTAMP
    DO
       UPDATE reservations SET 
       start_date = start_date - INTERVAL 1 HOUR, 
       end_date = end_date - INTERVAL 1 HOUR, 
       return_date = IF(ISNULL(return_date), null, return_date - INTERVAL 1 HOUR);");
}

echo json_encode($response);

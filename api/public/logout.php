<?php
include("../includes.php");

function main()
{
    session_start();
    unset($_SESSION["uid"]);

    echo json_encode(array('result' => true));
}

main();

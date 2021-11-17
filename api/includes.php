<?php
/* Include all non public modules */

// include absolute to not have problem with different paths
$root = $_SERVER['DOCUMENT_ROOT'] . '/api';

include_once($root . '/hidden.php');
include_once($root . '/headers.php');
include_once($root . '/helpers/DbManager.php');

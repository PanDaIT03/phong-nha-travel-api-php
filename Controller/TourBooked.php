<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Methods: *');

    include_once('../Model/getTour.php');
    include_once('../Model/postTour.php');
    include_once('../Model/deleteTour.php');
    include_once('../Model/putTour.php');

    $method = $_SERVER['REQUEST_METHOD'];
    switch($method) {
        case 'value':
            # code...
            break;
    }
?>
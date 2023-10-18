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
    $url = $_SERVER['REQUEST_URI'];
    $url_components = parse_url($url);
    switch ($method) {
        case 'GET':
            $modelTour = new getAPI();
            
            if(!empty($url_components['query'])) {
                parse_str($url_components['query'], $params);

                if(in_array("tourCategory", $params)) {
                    $tour = $modelTour->getTourCategory();
                    echo json_encode($tour);
                }
                else if(in_array("booked", $params['q'])) {
                    $tour = $modelTour->getTourBooked($params['q']['data']);
                    echo json_encode($tour);
                }
                else if(in_array("coupon", $params['q'])) {
                    $tour = $modelTour->getCoupon();
                    echo json_encode($tour);
                }
                else if(in_array("bookeDetail", $params['q'])) {
                    $tour = $modelTour->getBookeDetailByID($params['q']['data']);
                    echo json_encode($tour);
                }
                else if(in_array("reviewTour", $params['q'])) {
                    $tour = $modelTour->getTourReview($params['q']['data']);
                    echo json_encode($tour);
                }
                else if(in_array("search", $params['q'])) {
                    $tour = $modelTour->getTourSearch($params['q']['data']);
                    echo json_encode($tour);
                }
            }
            else {
                $tour = $modelTour->getTour();
                echo json_encode($tour);
            }

            break;
        case 'POST':
            $modelTour = new postTour();
            $input = json_decode(file_get_contents('php://input'));

            $params = get_object_vars($input);
            
            if(strcmp("cart", $params['name']) == 0) {
                $tour = $modelTour->insertTour(($params['data']));
                echo json_encode($tour);
            }
            else if(strcmp("coupon", $params['name']) == 0) {
                $tour = $modelTour->insertCoupon(($params['data']));
                echo json_encode($tour);
            }
            else if(strcmp("checkout", $params['name']) == 0) {
                $tour = $modelTour->insertCheckout(($params['data']));
                echo json_encode($tour);
            }

            break;
        case 'DELETE':
            $modelTour = new deleteTour();
            
            if(!empty($url_components['query'])) {
                parse_str($url_components['query'], $params);
                
                $tour = $modelTour->deleteCartByID($params['q']);
                echo json_encode($tour);
            }

            break;
        case 'PUT':
            $modelTour = new putTour();
            $input = json_decode(file_get_contents('php://input'));
            
            $params = get_object_vars($input);

            if(strcmp("quantity", $params['name']) == 0) {
                $tour = $modelTour->updateQuantity($params['data']);
                echo json_encode($tour);
            }

            break;
    }
?>
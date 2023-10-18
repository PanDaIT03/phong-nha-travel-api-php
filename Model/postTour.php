<?php
    include_once('../Database/DbConnect.php');

    class postTour {
        public function insertTour($params) {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            $sql = "
                CALL sp_insertCart('$params->name', '$params->email', '$params->tel',
                    '$params->date', '$params->quantity', $params->id);
            ";

            $stmt = $conn->prepare($sql);
            if($stmt->execute())
                return ['status' => 1, 'message' => 'Insert Success'];
            else
                return ['status' => 0, 'message' => 'Insert Failure'];
            return $sql;
        }

        public function insertCoupon($params) {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            $sql = "
                CALL sp_insertCartCoupon('$params');
            ";

            $stmt = $conn->prepare($sql);
            if($stmt->execute())
                return ['status' => 1, 'message' => 'Insert Success'];
            else
                return ['status' => 0, 'message' => 'Insert Failure'];
        }

        public function insertCheckout($params) {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            $sql = "
                CALL sp_checkoutDetail('$params->firstName', '$params->lastName', '$params->region',
                    '$params->adress', '$params->postOfficeCode', '$params->province', '$params->tel',
                    '$params->email', '$params->note', '$params->paymentMethodID');
                CALL sp_checkout();
            ";

            $stmt = $conn->prepare($sql);
            if($stmt->execute())
                return ['status' => 1, 'message' => 'Insert Success'];
            else
                return ['status' => 0, 'message' => 'Insert Failure'];
        }
    }
?>
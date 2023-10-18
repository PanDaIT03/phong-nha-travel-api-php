<?php
    include_once('../Database/DbConnect.php');

    class putTour {
        public function updateQuantity($params) {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            $sql = "
                CALL sp_updateQuantity($params->id, $params->quantity);
            ";

            $stmt = $conn->prepare($sql);
            if($stmt->execute())
                return ['status' => 1, 'message' => 'Update Success'];
            else
                return ['status' => 0, 'message' => 'Update Failure'];
        }
    }
?>
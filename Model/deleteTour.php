<?php
    include_once('../Database/DbConnect.php');

    class deleteTour {
        public function deleteCartByID($ID)
        {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            $sql = "
                CALL sp_deleteCart($ID);
            ";

            $stmt = $conn->prepare($sql);
            if($stmt->execute())
                return ['status' => 1, 'message' => 'Delete Success'];
            else
                return ['status' => 0, 'message' => 'Delete Failure'];
        }
    }
?>
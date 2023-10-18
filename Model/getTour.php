<?php
    include_once('../Database/DbConnect.php');

    class getAPI {
        public function getTour() {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            $sql = "
                SELECT t.id as id, t.name, t.description, img.image, tp.title, tp.id as topicID, t.priceAdult as price, 
                    t.priceChildren as childrenPrice  
                FROM tours AS t, images AS img, topics AS tp
                WHERE t.id = img.tour_id and tp.id = t.topic_id
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $user;
        }

        public function getTourReview($tourName) {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            $sql = "
                SELECT t.id as id, t.name, t.description, img.image, tp.title, tp.id as topicID, t.priceAdult as price, 
                    t.priceChildren as childrenPrice  
                FROM tours AS t, images AS img, topics AS tp
                WHERE t.id = img.tour_id and tp.id = t.topic_id
                    and t.name = '$tourName'
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user;
        }

        public function getTourBooked($params)
        {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            if(strcmp("checkout", $params) == 0)
                $statement = " AND C.PAYMENT_STATUS = 0";
            else
                $statement = "";

            $sql = "
                SELECT C.ID AS cartID, T.id AS tour_ID, T.name AS name, T.priceAdult AS price, TP.title AS topic,
                    IMG.image AS image, C.QUANTITY AS quantity, C.BOOKE_DATE AS bookeDate, C.PAYMENT_STATUS AS paymentStatus
                FROM cart AS C, tours AS T, images AS IMG, topics AS TP
                WHERE C.TOUR_ID = T.id AND IMG.tour_id = T.id AND T.topic_id = TP.id $statement
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $user;
        }

        public function getBookeDetailByID($ID)
        {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            $sql = "
                CALL sp_selectBookeDetails($ID)
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $user;
        }

        public function getTourCategory()
        {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            $sql = "
                SELECT T.id AS id_tour, C.id AS id_category, C.name
                FROM category AS C, tour_category AS TC, tours AS T
                WHERE C.id = TC.id_category AND T.id = TC.id_tour
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $user;
        }

        public function getCoupon()
        {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            $sql = "
                SELECT id, code, value
                FROM cartCoupon
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $user;
        }

        private function checkIsNULL($data) {
            if($data === NULL) {
                return true;
            } else {
                return false;
            }
        }
        
        public function getTourSearch($params)
        {
            $objDb = new DbConnect();
            $conn = $objDb->connect();

            $obj = new stdClass();
            foreach ($params as $key => $value) {
                $obj->$key = $value;
            }
            
            $sql = "
                CALL sp_searchTour('$obj->tourName', $obj->minPrice,
                $obj->maxPrice, '$obj->category')
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $user;
        }
    }
?>
<?php
include 'functions.php';

function processFormData($type){

// Initialize the database connection
global $data_base;
$data_base = connectToDatabase();
// Process based on the operation type
switch ($type) {
    case '1':
        $image_path = $_POST["image_path"];
        $basePath = "assets\\Car Images\\";
        $finalPath = $basePath . $image_path;
        $row['company'] = $_POST["company_name"];
        $row['model'] = $_POST["model_name"];
        $row['year_made'] = $_POST["year_made"];
        $row['image_path'] = $finalPath;
        $row['car_status'] = 'Available';
        $row['price_per_day'] = $_POST["price"];
        $row['office_num'] = $_POST["office_num"];
        insertInDb($row);
        break;

    case '2':
        modifyStatus($_POST["car_id"], $_POST["status"]);
        break;

    case '3':
        $start = $_POST["start_date"];
        $end = $_POST["end_date"];
        $sql = "SELECT *
                FROM reservation 
                JOIN car ON reservation.car_id = car.car_id 
                JOIN customer ON reservation.customer_id = customer.customer_id
                WHERE reservation.start_date >= '$start' AND reservation.return_date <= '$end'";
        $result = $data_base->query($sql);
        display($result);
        break;

    case '4':
        $car_id = $_POST["car_id"];
        $start = $_POST["start_date"];
        $end = $_POST["end_date"];

        $sql = "SELECT *
                FROM reservation 
                JOIN car ON reservation.car_id = car.car_id 
                WHERE car.car_id = '$car_id'
                  AND DATE(reservation.start_date) >='$start'
                  AND DATE(reservation.return_date) <= '$end'";
        $result = $data_base->query($sql);
        display($result);
        break;

    case '5':
        $day = $_POST["day"];
        $sql ="SELECT car.car_id,
            CASE
                WHEN '$day' BETWEEN reservation.start_date AND reservation.return_date THEN 'Reserved'
                ELSE 'Available'
            END AS car_status
        FROM
            car 
        LEFT JOIN reservation  ON car.car_id = reservation.car_id
        ORDER BY car.car_id";
        $result = $data_base->query($sql);
        display($result);
        break;
        
    case '6':
        $customer_id = $_POST["customer_id"];
        $sql = "SELECT customer.customer_id, customer.Fname, customer.Lname, customer.email, car.company, car.model, car.year_made, car.car_id
                FROM car 
                JOIN reservation ON reservation.car_id = car.car_id
                JOIN customer ON reservation.customer_id = customer.customer_id
                WHERE customer.customer_id = '$customer_id'";
        $result = $data_base->query($sql);

        if ($result === false) {
            die("Error in SQL query: " . $data_base->error);
        }

        display($result);
        break;

        case '7':
            $start_date = $_POST["start_date"];
            $end_date = $_POST["end_date"];
            $sql = "SELECT start_date AS payment_day, SUM(total_payment) AS total_payment
            FROM payment 
            WHERE start_date BETWEEN '$start_date' AND '$end_date'
            GROUP BY start_date";
               
            
            $result = $data_base->query($sql);

        if ($result === false) {
            die("Error in SQL query: " . $data_base->error);
        }

        display($result);    
        break;
    default:
        // Handle the default case or add additional cases as needed
        break;
}
// Close the database connection
$data_base->close();
}
?>

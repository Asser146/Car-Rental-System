<?php
global $data_base;
$data_base = mysqli_connect("localhost", "root", "", "car rental company");

if (!$data_base) {
    die("Connection failed: " . mysqli_connect_error());
}

function initDB($currentDate)
{
    global $data_base;

    $sql = "UPDATE car
            SET car_status = 
                CASE 
                    WHEN car_id IN (SELECT car_id FROM reservation WHERE '$currentDate' BETWEEN reservation.start_date AND reservation.return_date) THEN 'Rented'
                    ELSE 'Available'
                END";
    
    $result = $data_base->query($sql);

    if ($result === false) {
        echo "Error updating car_status: " . $data_base->error;
    }
}



function makeConnection() {
    global $data_base;
    return $data_base;
}
function display($result){
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<table border='1'>";
        // Display headers based on column names
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo "<th>$key</th>";
        }
        echo "</tr>";
        // Display data rows
        $result->data_seek(0); // Reset the result set pointer
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No Result\n";
    }
}
function insertInDb($row) {
    global $data_base;
    $sql = "INSERT INTO car (";
    $sql .= implode(", ", array_keys($row));
    $sql .= ") VALUES ('" . implode("', '", $row) . "')";
    $result = $data_base->query($sql);
    if ($result === false) {
        echo "Error inserting row: " . $data_base->error;
    } else {
        echo "Row inserted successfully!";
    }
}

function modifyStatus($car_id, $status) {
    global $data_base; 
    $sql = "SELECT * FROM car WHERE car_id = '$car_id'";
    $result = $data_base->query($sql);
    $row = $result->fetch_assoc();
    $row['car_status'] = $status;
    unset($row['car_id']);
    $sql = "UPDATE car SET ";
    foreach ($row as $column => $value) {
        $sql .= "$column = '$value', ";
    }
    $sql = rtrim($sql, ", ");
    $sql .= " WHERE car_id = $car_id"; 
    $result = $data_base->query($sql);
    if ($result === false) {
        echo "Error updating row: " . $data_base->error;
    } else {
        echo "Row updated successfully!";
    }
}
$type = $_POST["type"];
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($type == '1') {
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
    insertInDb( $row); 
}
else if ($type == '2') {
modifyStatus($_POST["car_id"], $_POST["status"]);
}
else if ($type == '3') {
    $start = $_POST["start_date"];
    $end = $_POST["end_date"];
    $sql = "SELECT *
            FROM reservation 
            JOIN car ON reservation.car_id = car.car_id 
            JOIN customer ON reservation.customer_id = customer.customer_id
            WHERE reservation.start_date >= '$start' AND reservation.return_date <= '$end'";

global $data_base;
$result = $data_base->query($sql);
display($result);
}
else if ($type == '4') {
    $car_id=$_POST["car_id"];
    $start = $_POST["start_date"];
    $end = $_POST["end_date"];

    $sql = "SELECT *
    FROM reservation 
    JOIN car ON reservation.car_id = car.car_id 
    WHERE car.car_id = '$car_id'
      AND DATE(reservation.start_date) >='$start'
      AND DATE(reservation.return_date) <= '$end'";
    global $data_base;
    $result = $data_base->query($sql);
    display($result);
}

else if ($type == '5') {
    $day = $_POST["day"];
    initDB($day);

    $sql = "SELECT  DISTINCT car.car_id, car.car_status 
            FROM car 
            LEFT JOIN reservation ON reservation.car_id = car.car_id";

    $result = $data_base->query($sql);

    if ($result) {
        display($result);
    } else {
        echo "Error executing query: " . $data_base->error;
    }
    //Return to original date
    $currentDate = date('Y-m-d');
    initDB($currentDate); 
}

else if ($type == '6') {
    $customer_id = $_POST["customer_id"];
    $sql = "SELECT customer.customer_id, customer.Fname, customer.Lname, customer.email, car.company, car.model, car.year_made, car.car_id
            FROM car 
            JOIN reservation ON reservation.car_id = car.car_id
            JOIN customer ON reservation.customer_id = customer.customer_id
            WHERE customer.customer_id = '$customer_id'";

    global $data_base;
    $result = $data_base->query($sql);

    if ($result === false) {
        die("Error in SQL query: " . $data_base->error);
    }

    display($result);
}

else if ($type == '7') {
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    $sql = "SELECT
                DATE(start_date) AS reservation_day,
                SUM(price_per_day) AS total_daily_payments
            FROM
                reservation
                JOIN car ON reservation.car_id = car.car_id
            WHERE
                start_date BETWEEN '$start_date' AND '$end_date'
            GROUP BY
                DATE(start_date)
            ORDER BY
                reservation_day";

    $result = $data_base->query($sql);

    if ($result) {
        // Assuming you have a function display() to handle the result display
        display($result);
    } else {
        echo "Error executing query: " . $data_base->error;
    }
}


?>

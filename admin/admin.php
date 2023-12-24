<?php
global $data_base;
$data_base = mysqli_connect("localhost", "root", "", "car rental company");

if (!$data_base) {
    die("Connection failed: " . mysqli_connect_error());
}

function makeConnection() {
    global $data_base;
    return $data_base;
}
function back() {
    header("Location: admin.html");
    exit();
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
echo "<button onclick='back();'>Back</button>";
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
        // You may want to return a success message or perform additional actions here
        echo "Row inserted successfully!";
    }
}

function modifyStatus($car_id, $status) {
    global $data_base; // Making $data_base global
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
    if($type=='2'){
    modifyStatus($_POST["car_id"], $_POST["status"]);}
    else{
        modifyStatus($_POST["car_id"],'out of service');
    }
}
else if ($type == '3') {
    $start = $_POST["start_date"];
    $end = $_POST["end_date"];

    $sql = "SELECT 'reservation_id','car_id','customer_id','start_date','return_date','return_office','company','model',
            'year_made','car_status','price_per_day','office_num','Fname','Lname','email'
            FROM reservation 
            JOIN car ON reservation.car_id = car.car_id 
            JOIN customer ON reservation.customer_id = customer.customer_id
            WHERE DATE(reservation.start_date) >= '$start' AND DATE(reservation.return_date) <= '$end'";

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
            WHERE car.car_id= $car_id AND DATE(reservation.start_date) >= '$start' AND DATE(reservation.return_date) <= '$end'";

    global $data_base;
    $result = $data_base->query($sql);
    display($result);
}
else if ($type == '5') {
    $day = $_POST["day"];
    $sql = "SELECT car.car_id, car.car_status 
    FROM car LEFT OUTER JOIN reservation 
    ON reservation.car_id = car.car_id 
    AND Date($day) BETWEEN DATE(reservation.start_date) AND DATE(reservation.return_date)";
    global $data_base;
    $result = $data_base->query($sql);
    display($result);
}
else if ($type == '6') {
    $customer_id = $_POST["customer_id"];
    $customer_id = $_POST["customer_id"];
    $sql = "SELECT customer.customer_id, customer.Fname, customer.Lname, customer.email, car.company, car.model, car.year_made, car.car_id
            FROM car 
            JOIN reservation ON reservation.car_id = car.car_id
            JOIN customer ON reservation.customer_id = customer.customer_id
            WHERE customer.customer_id = $customer_id";
    global $data_base;
    $result = $data_base->query($sql);
    display($result);
}





?>

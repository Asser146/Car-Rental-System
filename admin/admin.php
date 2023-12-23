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

function modifyDb($row) {
    global $data_base;

    $carId = $row['car_id'];
    unset($row['car_id']);
    $sql = "UPDATE car SET ";
    foreach ($row as $column => $value) {
        $sql .= "$column = '$value', ";
    }

    $sql = rtrim($sql, ", ");
    $sql .= " WHERE car_id = $carId"; 

    $result = $data_base->query($sql);

    if ($result === false) {
        echo "Error updating row: " . $data_base->error;
    } else {
        echo "Row updated successfully!";
    }
}


function modifyStatus($car_id, $status) {
    global $data_base; // Making $data_base global
    $sql = "SELECT * FROM car WHERE car_id = '$car_id'";
    $result = $data_base->query($sql);
    $row = $result->fetch_assoc();
    $row['car_status'] = $status;
    modifyDb($row);
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
    $row['car_status'] = 'Available'; // Fix the typo here ('car_stats' to 'car_status')
    $row['price_per_day'] = $_POST["price"];
    $row['office_num'] = $_POST["office_num"];

    insertInDb( $row); 
}
else if ($type == '2'||$type=='4') {
    if($type=='2'){
    modifyStatus($_POST["car_id"], $_POST["status"]);}
    else{
        modifyStatus($_POST["car_id"],'out of service');
    }
}
else if ($type == '3') {
    $id=$_POST["reserve_id"];
    $sql = "DELETE FROM reservation WHERE reservation_id = $id";
    global $data_base;
    $result = $data_base->query($sql);
    echo "Remove done";
}

?>

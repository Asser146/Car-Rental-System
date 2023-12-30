<?php
// Start PHP Session
session_start();

$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "car rental company";
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $car_id = $_SESSION['car_id'] ?? '';
    $sql = "SELECT reservation.start_date, reservation.return_date
            FROM reservation 
            JOIN car ON reservation.car_id = car.car_id
            WHERE car.car_id = '$car_id' AND (reservation.start_date > CURDATE() OR reservation.return_date > CURDATE())";
    $result = $conn->query($sql);
    
    $data = array();        
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo '<script>var queryResult = ' . json_encode($data) . ';</script>';
}
?>

<?php
// Retrieve values from the submitted form
$car_id = $_POST['car_id'];
$customer_id = $_POST['customer_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

// Access the database to get the car image path
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "car rental company"; // Avoid spaces in the database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the car image path using a prepared statement
$sql = "SELECT image_path FROM car WHERE car_id = ?";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("i", $car_id);

// Execute the statement
$stmt->execute();

// Bind the result variable
$stmt->bind_result($image_path);

// Fetch the result
if ($stmt->fetch()) {
    // Display the car image in the payment form
    echo "<img src='$image_path' alt='Car Image'>";

    // Display the rest of your payment form here
    // ...

} else {
    echo "Car not found in the database.";
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>

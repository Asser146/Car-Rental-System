<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <!-- Include CSS files for site layout and reservation form -->
    <link rel="stylesheet" href="includes/site_layout.css">
    <link rel="stylesheet" href="reserve.css">
</head>

<body style="margin-top: 50px">

    <header>
        <h1>Payment</h1>
    </header>

    <div class="container">
        <div class="form-container">
            <div id="form1" class="form">
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
                $database = "car rental company"; // Corrected the database name

                // Create a database connection
                $conn = new mysqli($host, $username, $password, $database);

                // Check the database connection
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
                    // Display the car image in the payment form with a specific width and height
                    echo "<img src='$image_path' alt='Car Image' style='width: 300px; height: 200px;'>";

                    // Display the rest of your payment form here
                    ?>
                    <h2>Enter your credit card details</h2>
                    <form id="paymentForm" action="process_payment.php" method="post" onsubmit="return validatePayment()">
                        <!-- Add hidden inputs for car_id, customer_id, start_date, and end_date -->
                        <input type="hidden" name="car_id" value="<?= htmlspecialchars($car_id) ?>">
                        <input type="hidden" name="customer_id" value="<?= htmlspecialchars($customer_id) ?>">
                        <input type="hidden" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
                        <input type="hidden" name="end_date" value="<?= htmlspecialchars($end_date) ?>">

                        <!-- Payment details -->
                        <div class="form-row">
                            <label for="cardNumber">Card Number:</label>
                            <input type="text" id="cardNumber" name="cardNumber" required>
                        </div>
                        <div class="form-row">
                            <label for="expiryDate">Expiry Date:</label>
                            <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
                        </div>
                        <div class="form-row">
                            <label for="cvv">CVV:</label>
                            <input type="text" id="cvv" name="cvv" required>
                        </div>

                        <!-- Add dropdown for selecting return office -->
                        <div class="form-row">
                            <label for="returnOffice">Return Office:</label>
                            <select id="returnOffice" name="returnOffice" required>
                                <?php
                                // Fetch office locations from the database
                                $officeQuery = "SELECT office_id, Location FROM office";
                                $officeStmt = $conn->prepare($officeQuery);

                                // Execute the statement
                                $officeStmt->execute();

                                // Bind the result variables
                                $officeStmt->bind_result($office_id, $location);

                                // Loop through the results and create options
                                while ($officeStmt->fetch()) {
                                    echo "<option value='{$office_id}'>{$location}</option>";
                                }

                                // Close the statement
                                $officeStmt->close();
                                ?>
                            </select>
                        </div>
                        <div class="form-row">
                            <!-- Use type="submit" for the submit button -->
                            <button type="submit" name="confirmPayment">Confirm Reservation</button>
                        </div>
                    </form>
                    <?php
                } else {
                    echo "Car not found in the database.";
                }

                // Close the statement and database connection
                $stmt->close();
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <script>
        function validatePayment() {
            // Add your payment validation logic here
            // Return true if the form is valid, otherwise return false
            return true;
        }
    </script>

</body>

</html>

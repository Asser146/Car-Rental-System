<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/site_layout.css">
    <link rel="stylesheet" href="reserve.css">

    <style>
        body {
            background: linear-gradient(to right, #e1eec3, #f05053);
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            font-size: 20px;
            font-weight: 600;
            text-align: center;
            border: 3px solid grey;
        }
    </style>
</head>

<!-- Header Content -->
<body>

    <div class="container">
        <div class="form-container">
            <div id="form1" class="form">
                <h2>Please select the reservation date of your car</h2>
                <form id="reservationForm" action="payment.php" method="post" onsubmit="return validateReservation()">
                    <?php
                    // Start PHP Session
                    session_start();

                    // Fetch car_id and customer_id from the session
                    $car_id = $_SESSION['car_id'] ?? '';
                    $customer_id = $_SESSION['customer_id'] ?? '';
                    $price_per_day = $_SESSION['price_per_day'] ?? '';
                    ?>
                    <!-- Add the hidden input for car_id, customer_id, start_date, end_date, and price_per_day -->
                    <input type="hidden" id="car_id" name="car_id" value="<?= htmlspecialchars($car_id); ?>">
                    <input type="hidden" id="customer_id" name="customer_id" value="<?= htmlspecialchars($customer_id); ?>">
                    <input type="hidden" id="start_date" name="start_date">
                    <input type="hidden" id="end_date" name="end_date">
                    <input type="hidden" id="price_per_day" name="price_per_day" value="<?= htmlspecialchars($price_per_day); ?>">

                    <div class="form-row">
                        <label for="field1">Start Date:</label>
                        <input type="date" id="field1" name="start_date" pattern="\d{4}-\d{2}-\d{2}" required>
                    </div>
                    <div class="form-row">
                        <label for="field2">Return Date:</label>
                        <input type="date" id="field2" name="end_date" pattern="\d{4}-\d{2}-\d{2}" required>
                    </div>
                    <div class="form-row payment-btn">
                        <input type="submit" value="Pay">
                    </div>
                </form>
            </div>
        </div>
        <?php
// Database connection
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "car rental company";

$conn = new mysqli($host, $username, $password, $database);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $car_id = $_SESSION['car_id'] ?? '';

    $sql = "SELECT reservation.start_date, reservation.return_date
            FROM reservation 
            JOIN car ON reservation.car_id = car.car_id
            WHERE car.car_id = '$car_id' AND (reservation.start_date > CURDATE() OR reservation.return_date > CURDATE())";

    $result = $conn->query($sql);
    echo 'PREVIOUS RESERVATIONS: ';
    if ($result->num_rows > 0) {
        echo '<table>';
        // Display headers based on column names
        echo '<tr>';
        $row = $result->fetch_assoc();
        foreach ($row as $key => $value) {
            echo '<th>' . htmlspecialchars($key) . '</th>';
        }
        echo '</tr>';
        // Display data rows
        $result->data_seek(0); // Reset the result set pointer
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            foreach ($row as $value) {
                echo '<td>' . htmlspecialchars($value) . '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "NONE";  
    }
}
?>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let startDateInput, endDateInput;

            // Assume fetchReservedDates is defined elsewhere in your code
            // You may need to modify this part based on your actual implementation
            fetchReservedDates(<?php echo json_encode($car_id); ?>)
                .then(reservedDates => {
                    startDateInput = document.getElementById('field1');
                    endDateInput = document.getElementById('field2');

                    const today = new Date().toISOString().split('T')[0];
                    startDateInput.min = today;

                    startDateInput.addEventListener('input', function () {
                        endDateInput.min = startDateInput.value;

                        const reservedStart = new Date(startDateInput.value);
                        const reservedEnd = new Date(endDateInput.value);
                        endDateInput.disabled = reservedDates.some(date =>
                            isDateBetween(new Date(date), reservedStart, reservedEnd)
                        );
                    });
                })
                .catch(error => {
                    console.error('Error fetching reserved dates:', error);
                });

            const reservationForm = document.getElementById('reservationForm');

            reservationForm.addEventListener('submit', function (event) {
                // Set the values of hidden inputs before submitting the form
                document.getElementById('start_date').value = startDateInput.value;
                document.getElementById('end_date').value = endDateInput.value;
            });
        });
    </script>
</body>

</html>

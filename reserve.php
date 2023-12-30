<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/site_layout.css">
    <link rel="stylesheet" href="reserve.css">
</head>

<body>
    <?php include 'common/database_connection.php'; ?>

    <div class="container">
        <div class="form-container">
            <div id="form1" class="form">
                <h2>Please select the reservation date of your car</h2>
                <form id="reservationForm" action="payment.php" method="post" onsubmit="return validateReservation()">
                    <?php
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
                <script>
                    // Define queryResult before including reservation.js
                    var queryResult = <?= json_encode($data); ?>;
                  
                </script>
                <script src="reservation_validation.js" defer></script>
            </div>
        </div>

        <?php include 'common/display_previous_reservations.php'; ?>
    </div>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/site_layout.css">
    <link rel="stylesheet" href="reserve.css">
</head>

<!-- Header Content -->
<header>
    <h1>Reservation</h1>
</header>

<!-- Body Content -->
<body style="margin-top: 100px">

    <div class="container">
        <div class="form-container">
            <div id="form1" class="form">
                <h2>Please select the reservation date of your car</h2>
                <form id="reservationForm" action="payment.php" method="post" onsubmit="return validateReservation()">
                    <?php
                    // Start PHP Session
                    session_start();

                    // Fetch car_id and customer_id from the session
                    $car_id = isset($_SESSION['car_id']) ? $_SESSION['car_id'] : '';
                    $customer_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : '';
                    ?>
                    <!-- Add the hidden input for car_id, customer_id, start_date, and end_date -->
                    <input type="hidden" id="car_id" name="car_id" value="<?php echo htmlspecialchars($car_id); ?>">
                    <input type="hidden" id="customer_id" name="customer_id" value="<?php echo htmlspecialchars($customer_id); ?>">
                    <input type="hidden" id="start_date" name="start_date">
                    <input type="hidden" id="end_date" name="end_date">
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

<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] == 0) {
    header("Location: login_page.html");
    exit();
}

// Include your database connection code here (replace with your actual connection details)
$data_base = mysqli_connect("localhost", "root", "", "car rental company");

if (!$data_base) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user bookings from the database
$customer_id = $_SESSION['customer_id'];
$sql = "SELECT reservation.reservation_id, CONCAT(car.company, ' ', car.model) AS car_name, reservation.start_date, reservation.return_date, office.Location AS return_office
        FROM reservation
        INNER JOIN car ON reservation.car_id = car.car_id
        INNER JOIN office ON reservation.return_office = office.office_id
        WHERE reservation.customer_id = '$customer_id'";
$result = $data_base->query($sql);

include("includes/pages_header.php");
?>
<style>
    body {
      margin-top: 120px; 
    }
</style>

<!-- Display My Bookings content -->
<div class="container">
    <h2>My Bookings</h2>
    <?php if ($result->num_rows > 0) { ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Car Name</th>
                    <th>Pickup Date</th>
                    <th>Return Date</th>
                    <th>Return Office</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['reservation_id']; ?></td>
                        <td><?php echo $row['car_name']; ?></td>
                        <td><?php echo $row['start_date']; ?></td>
                        <td><?php echo $row['return_date']; ?></td>
                        <td><?php echo $row['return_office']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No bookings found.</p>
    <?php } ?>
</div>

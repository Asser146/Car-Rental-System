<?php
session_start();
include('includes/config.php');
error_reporting(0);

// Check if car_id is provided in the URL
if (isset($_GET['vhid'])) {
    $car_id = $_GET['vhid'];

    // Fetch car details based on car_id
    $sql = "SELECT car.*, office.Location FROM car 
            JOIN office ON car.office_num = office.office_id 
            WHERE car.car_id = :car_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':car_id', $car_id, PDO::PARAM_INT);
    $query->execute();
    $carDetails = $query->fetch(PDO::FETCH_OBJ);

    // Include header
    include('includes/pages_header.php');
    // Include CSS file
    include('assets\css\search-page.css');
    ?>
    <!-- Display car details using the fetched data -->
    <div class="container" style="margin-top: 150px;"> <!-- Set the margin-top to 150px -->
        <div class="row">
            <div class="col-md-12">
                <h2 style="margin-bottom: 10px;"><?php echo htmlentities($carDetails->company . ' ' . $carDetails->model); ?></h2>
                <div class="picture-frame" style="border: 2px solid white; padding: 10px;"> <!-- Set the border color to white -->
                    <img src="<?php echo htmlentities($carDetails->image_path); ?>" alt="Car Image" style="max-width: 100%; height: auto;">
                </div>
                <p>Year: <?php echo htmlentities($carDetails->year_made); ?></p>
                <p>Price Per Day: $<?php echo htmlentities($carDetails->price_per_day); ?></p>
                <p>Status: 
                    <?php if ($carDetails->car_status == 'Available') : ?>
                        <span style="color: green;"><?php echo htmlentities($carDetails->car_status); ?></span>
                        <a href="payment.php" style="color: green; text-decoration: none;">
                            <span style="color: green; background-color: #c8e6c9; padding: 10px; margin-left: 10px;">Reserve</span>
                        </a>
                    <?php else : ?>
                        <span style="color: red;"><?php echo htmlentities($carDetails->car_status); ?></span>
                    <?php endif; ?>
                </p>
                <p>Location: <?php echo htmlentities($carDetails->Location); ?></p>
                <!-- Add more details as needed -->
            </div>
        </div>
    </div>
    <?php
} else {
    // Redirect to search page if car_id is not provided
    header("Location: search-car-result.php");
    exit();
}
?>

<?php
session_start();
include('includes/config.php');
error_reporting(0);

// Initialize the WHERE clause for the SQL query
$whereClause = " WHERE 1 ";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if Brand is selected
    if (isset($_GET['brand']) && $_GET['brand'] != 'Select Brand') {
        $brand = $_GET['brand'];
        $whereClause .= " AND car.company = '$brand' ";
    }

    // Check if Year is selected
    if (isset($_GET['year']) && $_GET['year'] != 'year') {
        $year = $_GET['year'];
        $whereClause .= " AND car.year_made = '$year' ";
    }

    // Check if Status is selected
    if (isset($_GET['status']) && $_GET['status'] != 'all') {
        $status = $_GET['status'];
        $whereClause .= " AND car.car_status = '$status' ";
    }

    // Check if Office Location is selected
    if (isset($_GET['office_location']) && $_GET['office_location'] != 'all') {
        $officeLocation = $_GET['office_location'];
        $whereClause .= " AND office.Location = '$officeLocation' ";
    }
}

// Final SQL query with dynamic WHERE clause
$sql = "SELECT car.*, office.Location FROM car 
        JOIN office ON car.office_num = office.office_id 
        $whereClause
        ORDER BY car_id DESC LIMIT 10";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

// ... (rest of the existing code)

?>

<!-- Header -->
<?php include('includes/pages_header.php'); ?>
<!-- /Header -->
<?php include('assets\css\search-page.css'); ?>

<!-- Listing -->
<section class="listing-page">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-9 col-md-push-3">
                <div class="result-sorting-wrapper">
                    <div class="sorting-count" id="carResults">
                        <?php
                        $counter = 0;

                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                                $brand = htmlentities($result->company);
                                ?>
                                <div class="car-entity">
                                    <div class="recent_post_img">
                                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->car_id); ?>">
                                            <img src="<?php echo htmlentities($result->image_path); ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="recent_post_title">
                                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->car_id); ?>">
                                            <?php echo $brand; ?>, <?php echo htmlentities($result->model); ?>
                                        </a>
                                        <p class="widget_price">$<?php echo htmlentities($result->price_per_day); ?> Per Day</p>
                                        <p class="widget_status">Status: <?php echo htmlentities($result->car_status); ?></p>
                                        <p class="widget_info">Year: <?php echo htmlentities($result->year_made); ?></p>
                                        <p class="widget_location">Location: <?php echo htmlentities($result->Location); ?></p>
                                    </div>
                                </div>
                                <?php
                                $counter++;
                            }
                        } else {
                            echo "<p>No cars found</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- /Main Content -->

            <!-- Side-Bar -->
            <aside class="col-md-3 col-md-pull-9">
                <!-- Search Form -->
                <div class="sidebar_widget">
                    <div class="widget_heading">
                        <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your Car </h5>
                    </div>
                    <div class="sidebar_filter">
                        <form id="searchForm" method="get" action="">
                            <!-- Brand Selection -->
                            <div class="form-group select">
                                <select class="form-control" name="brand" id="brand">
                                    <option>Select Brand</option>
                                    <?php
                                    $brandSql = "SELECT DISTINCT company FROM car";
                                    $brandQuery = $dbh->prepare($brandSql);
                                    $brandQuery->execute();
                                    $brands = $brandQuery->fetchAll(PDO::FETCH_OBJ);

                                    if ($brandQuery->rowCount() > 0) {
                                        foreach ($brands as $brand) {
                                            $selected = (isset($_GET['brand']) && $_GET['brand'] == $brand->company) ? 'selected' : '';
                                            echo '<option value="' . htmlentities($brand->company) . '" ' . $selected . '>' . htmlentities($brand->company) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- Year Made Selection -->
                            <div class="form-group select">
                                <select class="form-control" name="year" id="year">
                                    <option>year</option>
                                    <?php
                                    $brandSql = "SELECT DISTINCT year_made FROM car";
                                    $brandQuery = $dbh->prepare($brandSql);
                                    $brandQuery->execute();
                                    $brands = $brandQuery->fetchAll(PDO::FETCH_OBJ);

                                    if ($brandQuery->rowCount() > 0) {
                                        foreach ($brands as $brand) {
                                            $selected = (isset($_GET['year']) && $_GET['year'] == $brand->year_made) ? 'selected' : '';
                                            echo '<option value="' . htmlentities($brand->year_made) . '" ' . $selected . '>' . htmlentities($brand->year_made) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Status Selection -->
                            <div class="form-group select">
                                <select class="form-control" name="status" id="status">
                                    <option value="all">All Status</option>
                                    <?php
                                    $statusSql = "SELECT DISTINCT car_status FROM car";
                                    $statusQuery = $dbh->prepare($statusSql);
                                    $statusQuery->execute();
                                    $statuses = $statusQuery->fetchAll(PDO::FETCH_OBJ);

                                    if ($statusQuery->rowCount() > 0) {
                                        foreach ($statuses as $status) {
                                            $selected = (isset($_GET['status']) && $_GET['status'] == $status->car_status) ? 'selected' : '';
                                            echo '<option value="' . htmlentities($status->car_status) . '" ' . $selected . '>' . htmlentities($status->car_status) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- Office Selection -->
                            <div class="form-group select">
                                <select class="form-control" name="office_location" id="officeLocation">
                                    <option value="all">Office Location</option>
                                    <?php
                                    $officeSql = "SELECT DISTINCT Location FROM office";
                                    $officeQuery = $dbh->prepare($officeSql);
                                    $officeQuery->execute();
                                    $offices = $officeQuery->fetchAll(PDO::FETCH_OBJ);

                                    if ($officeQuery->rowCount() > 0) {
                                        foreach ($offices as $office) {
                                            $selected = (isset($_GET['office_location']) && $_GET['office_location'] == $office->Location) ? 'selected' : '';
                                            echo '<option value="' . htmlentities($office->Location) . '" ' . $selected . '>' . htmlentities($office->Location) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- Search Button -->
                            <div class="form-group">
                                <button type="button" class="btn btn-block" onclick="searchCars()">
                                    <i class="fa fa-search" aria-hidden="true"></i> Search Car
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>
            <!-- /Side-Bar -->
        </div>
    </div>
</section>

<script>
    function searchCars() {
        document.getElementById('searchForm').submit();
    }
</script>

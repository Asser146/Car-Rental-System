<?php
function connectToDatabase() {
    $data_base = mysqli_connect("localhost", "root", "", "car rental company");

    if (!$data_base) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $data_base;
}
global $data_base;
$data_base = connectToDatabase();
function initDB($currentDate)
{
    $data_base;

    $sql = "UPDATE car
            SET car_status = 
                CASE 
                    WHEN car_id IN (SELECT car_id FROM reservation WHERE '$currentDate' BETWEEN reservation.start_date AND reservation.return_date) THEN 'Rented'
                    ELSE 'Available'
                END";
    global $data_base;
    $result = $data_base->query($sql);

    if ($result === false) {
        echo "Error updating car_status: " . $data_base->error;
    }
}

function display($result) {
?>
<html>
<head>
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
    text-align: center; /* Center-align the text */
    border: 3px solid grey; /* Add border for both columns and rows */
}

    </style>
</head>
<body>

</body>
</html>

    <?php
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo '<table>';
        // Display headers based on column names
        echo '<tr>';
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
        echo 'No Result\n';
    }

    echo '</body>';
    echo '</html>';
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
        echo "Row inserted successfully!";
    }
}

function modifyStatus($car_id, $status) {
    global $data_base; 
    $sql = "SELECT * FROM car WHERE car_id = '$car_id'";
    $result = $data_base->query($sql);
    $row = $result->fetch_assoc();
    $row['car_status'] = $status;
    unset($row['car_id']);
    $sql = "UPDATE car SET ";
    foreach ($row as $column => $value) {
        $sql .= "$column = '$value', ";
    }
    $sql = rtrim($sql, ", ");
    $sql .= " WHERE car_id = $car_id"; 
    $result = $data_base->query($sql);
    if ($result === false) {
        echo "Error updating row: " . $data_base->error;
    } else {
        echo "Row updated successfully!";
    }
}
function reserve($row) {
    global $data_base;
    $sql = "INSERT INTO reservation (";
    $sql .= implode(", ", array_keys($row));
    $sql .= ") VALUES ('" . implode("', '", $row) . "')";
    $result = $data_base->query($sql);
    if ($result === false) {
        echo "Error inserting row: " . $data_base->error;
    } else {
        echo "Car Reserved successfully!";
        header("Location: main.php");
        exit();
    }
}
?>
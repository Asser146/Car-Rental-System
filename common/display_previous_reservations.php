<?php
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
?>

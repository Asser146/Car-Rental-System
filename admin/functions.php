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
    global $data_base;

    $sql = "UPDATE car
            SET car_status = 
                CASE 
                    WHEN car_id IN (SELECT car_id FROM reservation WHERE '$currentDate' BETWEEN reservation.start_date AND reservation.return_date) THEN 'Rented'
                    ELSE 'Available'
                END";
    
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
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .tableContainer {
                background-color: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

            .close-btn {
                background-color: #f05053;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>

    <div class="tableContainer" id="tableContainer">
        <button class="close-btn" onclick="closeTable()">Close</button>
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

        echo '</div>';
        echo '</body>';
        echo '</html>';
        ?>

        <script>
            function closeTable() {
                document.getElementById("tableContainer").style.display = "none";
            }
        </script>
        <?php
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
        $sql = "UPDATE car SET car_status = '$status'
                WHERE car_id='$car_id'";
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

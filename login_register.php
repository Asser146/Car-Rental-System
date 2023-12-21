<?php
function makeConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "car rental company";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

$data_base = makeConnection();

if ($data_base) { 
  $userType = $_POST["userType"]; 
  $authType = $_POST["choice"]; 
    if ($authType == 1) { // Login mode
      $input_email = $_POST["logEmail"];
      $input_pass = $_POST["logPass"]; 
        if ($userType == 1) { // Client logged 
          echo "hereee";
            $sql = "SELECT * FROM client WHERE email = '$input_email'";
        } else { // Staff user logged 
            $sql = "SELECT * FROM staff_user WHERE email = '$input_email'";
        }
        $result = $data_base->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['email'] == $input_email && $row['password'] == $input_pass) {
                // Proceed to main page
                header("Location: main.html");
                exit();
            } else {
                // Incorrect email or password
                header("Location: login_page.html?login_error=1");
                exit();
            }
        } else {
            header("Location: login_page.html?login_error=2");
            exit();
        }
    } else { // Register mode
      $input_email = $_POST["regEmail"];
      $input_pass = $_POST["regPass"]; 
        $fname = $_POST["name1"]; 
        $lname = $_POST["name2"]; 
        if ($userType == 1) { // Client registered 
            $sql = "INSERT INTO client (fname, Lname, email, password) 
                    VALUES ('$fname', '$lname', '$input_email', '$input_pass')";
        } else { // Staff user registered 
            $sql = "INSERT INTO staff_user (fname, Lname, email, password) 
                    VALUES ('$fname', '$lname', '$input_email', '$input_pass')";
        }
        $data_base->query($sql);
        header("Location: main.html");
        exit();
    }
} else {
    echo "Error";
}
?>

<?php
$data_base = mysqli_connect("localhost", "root", "", "car rental company");

if (!$data_base) {
    die("Connection failed: " . mysqli_connect_error());
}

function makeConnection() {
    global $data_base;
    return $data_base;
}

function checkEmail($email, $userType) {
    global $data_base; // Making $data_base global
    $table = ($userType == 1) ? "customer" : "staff";
    $sql = "SELECT * FROM $table WHERE email = '$email'";
    $result = $data_base->query($sql);
    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
}
$userType = $_POST["userType"];
$authType = $_POST["choice"];
$table = ($userType == 1) ? "customer" : "staff";
if ($authType == 1) { // Login mode
    $input_email = $_POST["logEmail"];
    $input_pass = $_POST["logPass"];
    $sql = "SELECT * FROM $table WHERE email = '$input_email'";
    $result = $data_base->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['email'] == $input_email && $row['pass'] == $input_pass) {
            header("Location: main.html");
            exit();
        } else {
            // Incorrect email or password
            header("Location: login_page.html?login_error1=1");
            exit();
        }
    } else {
        header("Location: login_page.html?login_error2=1");
        exit();
    }
} else { // Register mode
    $input_email = $_POST["regEmail"];
    $input_pass = $_POST["regPass"];
    $fname = $_POST["name1"];
    $lname = $_POST["name2"];

    if (checkEmail($input_email, $userType)) {
        $sql = "INSERT INTO $table (fname, Lname, email, pass) VALUES ('$fname', '$lname', '$input_email', '$input_pass')";
    } else {
        header("Location: register_page.html?register_error=1");
        exit();
    }
    $data_base->query($sql);
    header("Location: main.html");
    exit();
}
?>

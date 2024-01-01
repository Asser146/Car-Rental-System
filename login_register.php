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
    global $data_base;
    $table = ($userType == 1) ? "customer" : "staff";
    $sql = "SELECT * FROM $table WHERE email = '$email'";
    $result = $data_base->query($sql);
    
    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
}

$authType = $_POST["choice"];
if ($authType == 1) { // Login mode
    $userType = $_POST["userType"];
    $table = ($userType == 1) ? "customer" : "staff";
    $input_email = $_POST["logEmail"];
    $input_pass = $_POST["logPass"];
    $sql = "SELECT * FROM $table WHERE email = '$input_email'";
    $result = $data_base->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if (password_verify($input_pass, $row['pass'])) {
            session_start();
            $_SESSION['login'] = 1;
            $_SESSION['customer_id'] = $row['customer_id'];
            $_SESSION['fname'] = $row['Fname'];
            $main = ($userType == 1) ? "main.php" : "admin/admin_page.php";
            header("Location: {$main}");
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
    $userType = $_POST["userType"];
    $table = ($userType == 1) ? "customer" : "staff";
    $office_num = ($userType == 2) ? $_POST["office_num"] : "none";
    $input_email = $_POST["regEmail"];
    $input_pass = $_POST["regPass"];
    $fname = $_POST["name1"];
    $lname = $_POST["name2"];

    if (checkEmail($input_email, $userType)) {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($input_pass, PASSWORD_DEFAULT);

        $sql = ($userType == 1) ?
            "INSERT INTO $table (fname, Lname, email, pass) VALUES ('$fname', '$lname', '$input_email', '$hashed_password')" :
            "INSERT INTO $table (Fname, Lname, office_num, email, pass) VALUES ('$fname', '$lname', '$office_num', '$input_email', '$hashed_password')";
    } else {
        ($userType == 1) ? header("Location: register_page.html?register_error=1") :
            header("Location: admin/admin_page.php?register_error=1");
        exit();
    }

    $data_base->query($sql);
    ($userType == 1) ? header("Location: login_page.html") : header("Location: admin/admin_page.php");
    exit();
}
?>

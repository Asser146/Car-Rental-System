<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/site_layout.css">
    <link rel="stylesheet" href="admin.css">
</head>
<script src="admin.js"></script>
<header>
    <h1>Admin Portal</h1>
</header>
<script src="../includes/site_layout.js"></script>
<body>
<div class="container">
    <div class="button-container">
        <button onclick="toggleForm('form1')">Add Car</button>
        <button onclick="toggleForm('form2')">Modify Car Status</button>
        <button onclick="toggleForm('form3')">Reservations</button>
        <button onclick="toggleForm('form4')">Car Reservations</button>
        <button onclick="toggleForm('form5')">Car Status</button>
        <button onclick="toggleForm('form6')">Customer Reservation</button>
        <button onclick="toggleForm('form7')">Finance Details</button>
        <button onclick="toggleForm('form8')">Add Staff User</button>
    </div>
    <div class="form-container">
        <div id="form1" class="form">
            <h2>Insert New Car To The System</h2>
            <form method="post" onsubmit="return validateInsert()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <input type="hidden" id="type" name="type" value='1'>
                <div class="form-row">
                    <label for="field1">Company Name:</label>
                    <input type="text" id="field1" name="company_name" placeholder="Enter Company">
                </div>
                <div class="form-row">
                    <label for="field2">Model Name:</label>
                    <input type="text" id="field2" name="model_name" placeholder="Enter Model">
                </div>
                <div class="form-row">
                    <label for="field3">Year:</label>
                    <input type="text" id="field3" name="year_made" placeholder="Enter Year">
                </div>
                <div class="form-row">
                    <label for="field3">Price/Day:</label>
                    <input type="number" id="field4" name="price" placeholder="Enter Price">
                </div>
                <div>
                    <label for="dropdown">Select Office Id:</label>
                    <select name="office_num" id="dropdown">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="field4">Image:</label>
                    <input type="file" id="imageUpload" name="image_path" accept="image/*">
                </div>
                <div class="form-row submit-btn">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
        <div id="form2" class="form">
            <h2>Modify Car Status</h2>
            <form method="post" onsubmit="return validateModify()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <input type="hidden" id="type" name="type" value='2'>
                <div class="form-row">
                    <label for="field5">Car Id:</label>
                    <input type="text" id="field5" name="car_id" placeholder="Enter Car Id">
                </div>
                <div class="form-row">
                <label for="field6">Select Office Id:</label>
                    <select id="field6" name="status">
                        <option value='1'>Available</option>
                        <option value='2'>Rented</option>
                        <option value='3'>Out of Service</option>
                    </select>
                </div>

                <div class="form-row submit-btn">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
        <div id="form3" class="form">
            <h2>Display Reservations Within a Specified Period including all Car and Customer Info</h2>
            <form method="post" onsubmit="return validateReservation()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <input type="hidden" id="type" name="type" value='3'>
                <div class="form-row">
                    <label for="field7">Start Date:</label>
                    <input type="date" id="field7" name="start_date" pattern="\d{4}-\d{2}-\d{2}" required>
                </div>
                <div class="form-row">
                    <label for="field7">End Date:</label>
                    <input type="date" id="field8" name="end_date" pattern="\d{4}-\d{2}-\d{2}" required>
                </div>
                <div class="form-row submit-btn">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
        <div id="form4" class="form">
            <h2>Display All reservations of any Car within a specified period including all Car Info</h2>
            <form method="post" onsubmit="return validateCareRes()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <input type="hidden" id="type" name="type" value='4'>
                <div class="form-row">
                    <label for="field8">Car Id:</label>
                    <input type="text" id="field9" name="car_id" placeholder="Enter Car Id">
                </div>
                <div class="form-row">
                    <label for="field7">Start Date:</label>
                    <input type="date" id="field10" name="start_date">
                </div>
                <div class="form-row">
                    <label for="field7">End Date:</label>
                    <input type="date" id="field11" name="end_date">
                </div>
                <div class="form-row submit-btn">
                    <input type="submit" value="Submit">

                </div>
            </form>
        </div>
        <div id="form5" class="form">
            <h2>Display The status of all Cars on a specific day</h2>
            <form method="post" onsubmit="return validateStatus()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <input type="hidden" id="type" name="type" value='5'>
                <div class="form-row">
                    <label for="field7">Status on Day:</label>
                    <input type="date" id="field12" name="day">
                </div>
                <div class="form-row submit-btn">
                    <input type="submit" value="Submit">

                </div>
            </form>
        </div>
        <div id="form6" class="form">
            <h2>Customer Reservation</h2>
            <form method="post" onsubmit="return validateCustomerRes()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <input type="hidden" id="type" name="type" value='6'>
                <div class="form-row">
                    <label for="field7">Customer Id::</label>
                    <input type="number" id="field13" name="customer_id">
                </div>
                <div class="form-row submit-btn">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
        <div id="form7" class="form">
            <h2>Display Daily payments within specific period</h2>
            <form method="post" onsubmit="return validateFinance()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                <input type="hidden" id="type" name="type" value='7'>
                <div class="form-row">
                    <label for="field7">Start Date:</label>
                    <input type="date" id="field14" name="start_date">
                </div>
                <div class="form-row">
                    <label for="field7">End Date:</label>
                    <input type="date" id="field15" name="end_date">
                </div>
                <div class="form-row submit-btn">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
        <div id="form8" class="form">
            <h2>Add Staff User to the System</h2>
            <form action="../login_register.php" method="post" onsubmit="return validateStaff()">
                <input type="hidden"  name="choice" value='2'>
                <input type="hidden"  name="userType" value='2'>
                <div class="form-row">
                    <label for="field7">First Name:</label>
                    <input type="text" id="reg1" name="name1">
                </div>
                <div class="form-row">
                    <label for="field7">Last Name:</label>
                    <input type="text" id="reg2" name="name2">
                </div>
                <div class="form-row">
                    <label for="field7">Email:</label>
                    <input type="email" id="reg3" name="regEmail">
                </div>
                <div class="form-row">
                    <label for="field7">Password:</label>
                    <input type="password" id="reg4" name="regPass">
                </div>
                <div class="form-row">
                    <label for="field7">Confirmation Password:</label>
                    <input type="password" id="reg5">
                </div>
                <div class="form-row">
                    <label for="field7">Office Number:</label>
                    <input type="number" id="reg6" name="office_num">
                </div>
                <div class="form-row submit-btn">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
        <?php
    include 'forms.php';
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $type = $_POST["type"];
        // Call the specific function
        processFormData($type); // Calls the function from functions.php
    }
    ?>
    </div>    
</div>

</body>
</html>


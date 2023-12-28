<!DOCTYPE HTML>
<html lang="en">
<head>
<link rel="stylesheet" href="includes\site_layout.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>Car Rental Portal</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 
</head>
<body>

<header>
    <div class="default-header">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-md-2">
                    <div class="logo"> <a href="main.php"><img src="assets/images/logg.png" alt="logo"/></a> </div>
                </div>
                <div class="col-sm-9 col-md-10">
                    <?php
                    if (strlen($_SESSION['login']) == 0) {
                        ?>
                        <div class="login_btn">
                            <a href="login_page.html" class="btn btn-xs uppercase">Login</a>
                        </div>

                        <div class="register_btn">
                            <a href="register_page.html" class="btn btn-xs uppercase">Register</a>
                        </div>
                        <?php
                    } else {
                      $fname = $_SESSION['fname'];
                      ?>
                      <div class="welcome_message">
                          <p>Hii <?php echo $fname; ?>, Welcome to Car rental portal</p>
                      </div>
                      <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav id="navigation_bar" class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse"
                        class="navbar-toggle collapsed" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div class="header_wrap">
                <div class="collapse navbar-collapse" id="navigation">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="main.php">Home</a></li>
                        <li><a href="search-car-result.php">Search</a></li>
                    </ul>

                    <?php if (isset($_SESSION['login']) && $_SESSION['login'] != 0) { ?>
                        <div class="user_login">
                            <ul>
                                <li class="dropdown">
                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                                        <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="my-booking.php">My Booking</a></li>
                                        <li><a href="logout.php">Sign Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navigation end -->

</header>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 


</body>
<style>
    .welcome_message {
        margin-top: 20px; /* Adjust the value to add more or less space */
    }
</style>
</html>

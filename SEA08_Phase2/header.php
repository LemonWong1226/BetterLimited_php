<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["isLogin"]) || $_SESSION["isLogin"] !== true){
    header("location: index.php");
    exit;
}

function manager(){
    if ($_SESSION["position"] !== "Manager"){
        header("location: managerOnly.php");
    }
}

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Better Limited Management System</title>

    <!-- css -->
    <link rel="stylesheet" href="css/style.css">

    <!-- font and icon library   -->
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto:wght@500&family=Shizuru&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/6c581af1db.js" crossorigin="anonymous"></script>

    <!--   bootstrap and jquery library -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>


</head>

<body>

<!--Header-->
<nav class="navbar navbar-expand-md navbar-inverse">

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <a class="navbar-brand" href="homepage.php">Better Limited</a>


        <!-- for mobile screen size -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false">
            <span><i class="fa fa-bars"></i></span>
        </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav ml-auto ">
            <?php
            if (isset($_SESSION["position"]) && $_SESSION["position"] == "Staff"){
                echo <<<EOF
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sales
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="order.php">Place Order</a>
                        <a class="dropdown-item" href="orderRecord.php">Order / Delivery Record</a>
                        <a class="dropdown-item" href="customerList.php">Customer List</a>
                    </div>
                </li>
EOF;
            }
            if (isset($_SESSION["position"]) && $_SESSION["position"] == "Manager") {
                echo <<<EOF
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Manager
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="itemList.php">Item List</a>
                        <a class="dropdown-item" href="reportHome.php">Monthly Report</a>
                        <a class="dropdown-item" href="customerList.php">Customer List</a>
                    </div>
                </li>
EOF;
            }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php" onclick="return confirm('Are you sure to logout the account?')">Logout</a>
            </li>
        </ul>
    </div>
</nav>


<!-- Name tag bar and logout bar, it shows when user login successfully -->

<div class='container-fluid py-2 bg-info text-right text-white' id="nameBar">

    Welcome ! &nbsp; <?php echo ($_SESSION["staffName"]); ?>
    &nbsp;&nbsp;-&nbsp;&nbsp; <?php echo ($_SESSION["position"]); ?>&nbsp;&nbsp;&nbsp;
</div>



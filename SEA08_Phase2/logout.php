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


</head>

<body>

<?php
// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();
?>

<!--Header-->
<nav class="navbar navbar-expand-md navbar-inverse">

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <a class="navbar-brand" href="homepage.php">Better Limited</a>

    </div>
</nav>


<!-- Name tag bar and logout bar, it shows when user login successfully -->

<div class='container-fluid py-2 bg-info text-right text-white' id="nameBar">
<br>
</div>




<!--Main Content-->

<!-- Home page and company description -->
<div class="py-2 bg-white">
    <div class="container ">
        <div class="text-center py-5">
            <div class="col-md-10 text-center mx-auto py-5">
                <div class="text-black" id="bigTopic"> <b>Logout successfully</b></div>
            </div>

            <div>
                <a href="index.php" class="btn btn-secondary btn-lg">Back to Login page</a>
            </div>

        </div>
    </div>
</div>








<!--footer-->

<div class="bg-info">
    <div class="container my-3">
        <div class="row" style="">
            <div class="col-12 my-2 text-center text-white">
                Better Limited Management System 2022&copy;
            </div>
        </div>
    </div>
</div>


<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>

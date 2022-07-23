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
include "conn.php";
$conn = getDBconnection();

session_start();

// Define variables and initialize with empty values
$userId = $userPw = "";
$userId_error = $userPw_error = $login_error = "";
$success = true;


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["loginId"]))){
        $userId_error = "Your Staff Id is empty, please try again.";
        $success = false;
    } else{
        $userId = trim($_POST["loginId"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["loginPw"]))){
        $userPw_error = "Your password is empty, please try again.";
        $success = false;
    } else{
        $userPw = trim($_POST["loginPw"]);
    }

    // Validate credentials
    if($success){

        $sql = "SELECT * FROM Staff WHERE staffId = '$userId' and password = '$userPw'";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));


                // Check if username exists, if yes then verify password
                if(mysqli_num_rows($query) == 1){
                    session_start();
                    $login = mysqli_fetch_assoc($query);
                    // Store data in session variables
                    $_SESSION["isLogin"] = true;
                    $_SESSION["position"] = $login["position"];
                    $_SESSION["staffId"] = $login["staffID"];
                    $_SESSION["staffName"] = $login["staffName"];

                    // Redirect user to welcome page
                    header("location: homepage.php");
                }else{
                    $login_error = "Invalid username or password.";
                }
    } else{
        $login_error = "Invalid username or password.";
    }
    // Close connection
    mysqli_close($conn);
}

?>

<div class='container-fluid py-2 bg-info'>
    <br><br>
</div>


<!--Main Content-->

<!-- Home page and company description -->
<div class="py-2 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-8 text-center mx-auto py-5">
                <div class="text-primary" id="comTitle"> <b>Better Limited</b></div>
                <div class="text-black" id="topic">Welcome to the management system</div>
                <div class="text-black">Better Limited is an electronic appliance retail store. The Company's main business is
                    to sell small to large electronic appliances, such as hairdryers, TV, Air-Conditioner…etc.</div>
            </div>
        </div>
    </div>
</div>

<?php

if(!empty($userId_error)){
    echo '<div class="alert alert-danger">' . $userId_error . '</div>';
}
if(!empty($userPw_error)){
    echo '<div class="alert alert-danger">' . $userPw_error . '</div>';
}
if(empty($userId_error) && empty($userPw_error) && !empty($login_error)){
    echo '<div class="alert alert-danger">' . $login_error . '</div>';
}
?>


<div class="container">
    <div class="col-md-12 ">
        <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group ">
                <label for="loginId">Staff Id</label>
                <input type="text" class="form-control" name="loginId" placeholder="Please input your account name" >
            </div>
            <div class="form-group">
                <label for="loginPw">Password</label>
                <input type="password" class="form-control" name="loginPw" placeholder="Please input your password">
            </div>
            <br>
            <button type="submit" name="userLogin" class="btn btn-danger">Login</button>
        </form>
    </div>
</div>
<br>





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

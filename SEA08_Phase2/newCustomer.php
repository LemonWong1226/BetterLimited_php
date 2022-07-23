<?php
include 'header.php';
include "conn.php";
$conn = getDBconnection();


$error_message = $something_error = "";
$customerName = $customerEmail = $customerPhone = "";
$success = true;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(empty(trim($_POST["cusName"]))){
        $error_message = "Customer Name is missing";
        $success = false;
    } else{
        $customerName = trim($_POST["cusName"]);
    }
    if(empty(trim($_POST["cusEmail"]))){
        $error_message = "Customer Email is missing";
        $success = false;
    } else{
        $customerEmail = trim($_POST["cusEmail"]);
    }
    if(empty(($_POST["cusPhone"]))){
        $customerPhone = "";
    } else{
        $customerPhone = ($_POST["cusPhone"]);
    }

    if ($success){
        $sql = "INSERT INTO Customer(customerEmail, customerName, phoneNumber) VALUES('$customerEmail', '$customerName', '$customerPhone')";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        Header("Location: customerList.php");
    }else{
        $something_error = "Something error, Please check.";
    }
}
mysqli_close($conn);
?>



<!--Main Content-->

<!-- Home page and company description -->

<div class="py-2 bg-white">
    <div class="container">

        <div class="col-md-10 py-4">
				<span class="topic mx-5">
					<a href="customerList.php" class="btn btn-secondary btn-lg">Back</a>
				</span>
            <span class="topic text-black">Create New Customer</span>
            <hr>
        </div>

    </div>
</div>

<?php
if(!empty($error_message)){
    echo '<div class="alert alert-danger">' . $error_message . '</div>';
}
if(empty($error_message) && !empty($something_error)){
    echo '<div class="alert alert-danger">' . $something_error . '</div>';
}
?>

<div class="container">
    <div>
        <form class="" action="" method="POST">

            <div class=" row mx-3 my-4">
                <div class="col-md-4 col-sm-12">
                    Customer's Name
                </div>
                <input type="text" class="form-control col-md-4 col-sm-12" name="cusName" placeholder="Please input the customer name" required>
            </div>


            <div class=" row mx-3 my-4">
                <div class="col-md-4 col-sm-12">
                    Customer's Email
                </div>
                <input type="email" class="form-control col-md-4 col-sm-12" name="cusEmail" placeholder="Please input email format" required>
            </div>

            <div class=" row mx-3 my-4">
                <div class="col-md-4 col-sm-12">
                    Customer's Phone Number
                </div>
                <input type="number" class="form-control col-md-4 col-sm-12" name="cusPhone" maxlength="8" placeholder="Please input 8 digits">
            </div>


            <div class="mx-4 my-4">
                <button type="submit" name="submit" class="btn btn-primary col-md-2 col-sm-12"
                        onclick="return confirm('Confirm to create new customer ?')">Submit</button>
            </div>

        </form>
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

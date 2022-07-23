<?php
include 'header.php';

// only Manager can use this function
manager();

include "conn.php";
$conn = getDBconnection();

$itemId = $_GET['itemId'];
//$itemId = $conn->real_escape_string($itemId);

$error_message = $something_error = "";
$itemName = $itemQty = $itemPrice = $itemDes = "";
$success = true;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(empty(trim($_POST["itemName"]))){
        $error_message = "Item Name is missing";
        $success = false;
    } else{
        $itemName = trim($_POST["itemName"]);
    }
    if(empty(trim($_POST["itemQty"]))){
        $error_message = "Stock Quantity is missing";
        $success = false;
    } else{
        $itemQty = trim($_POST["itemQty"]);
    }
    if(empty(trim($_POST["itemPrice"]))){
        $error_message = "Price is missing";
        $success = false;
    } else{
        $itemPrice = trim($_POST["itemPrice"]);
    }
    if(empty(trim($_POST["itemDes"]))){
        $itemDes = null;
    } else{
        $itemDes = trim($_POST["itemDes"]);
    }

    if ($success){
        $sql = "UPDATE Item SET itemName = '$itemName', stockQuantity = '$itemQty', price = '$itemPrice', itemDescription = '$itemDes' WHERE itemID = '$itemId'";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        Header("Location: itemDetails.php?itemId=$itemId");
    }else{
        // Username doesn't exist, display a generic error message
        $something_error = "Something error, Please check.";
    }
}


?>

<!--Main Content-->

<!-- Home page and company description -->
<div class="py-2 bg-white">
    <div class="container">
        <div class="col-md-12 mx-auto py-4">
            <h2>Edit Item</h2>
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


$sql = "SELECT * FROM Item WHERE itemID = '$itemId'";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_num_rows($query) > 0) {
    $result = mysqli_fetch_assoc($query);
    echo <<<EOF
<div class="container">
    <div class="col-md-12 ">

        <form action="" method="post">

            <div class='detailTitle row mt-3 py-4'>
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Item Id
                </div>
                <div class='detailContent col-md-7 col-sm-12 '>
                    $result[itemID]
                </div>
            </div>

            <div class="detailTitle row my-3 py-4">
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Item Name
                </div>
                <input type="text" class="form-control col-md-7 col-sm-12" name="itemName" placeholder="Please input Item Name" value="$result[itemName]">
            </div>

            <div class="detailTitle row my-3 py-4">
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Stock Quantity
                </div>
                <input type="number" class="form-control col-md-2 col-sm-12" name="itemQty" value="$result[stockQuantity]" min="0" step="1">
            </div>


            <div class="detailTitle row my-3 py-4">
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Price(HKD)
                </div>
                <input type="number" class="form-control col-md-2 col-sm-12" name="itemPrice" value="$result[price]" min="0" step="1">
            </div>



            <div class="detailTitle row my-3 py-4">
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Description
                </div>
                <input type="text" class="form-control col-md-7 col-sm-12" name="itemDes" placeholder="Please input description" value="$result[itemDescription]">
            </div>

            <div class='row'>
                <div class='col-9 mt-5'>
                    <a href='itemDetails.php?itemId=$result[itemID]' class='btn btn-secondary btn-lg'>Back</a>
                </div>

                <!--   salesperson do not have permission to delete the customer -->
                <div class='col-2 mt-5 '>
                    <button type="submit" name="editConfirm" class="btn btn-lg btn-primary" onclick="return confirm('Confirm to edit this item ?')">Confirm</button>
                </div>
            </div>
        </form>
    </div>
</div>
EOF;
}else {
// Not found
    echo"<div class='container'>
	           <div class='row mt-2'>
	                <div class='col-12'>
	                    <a href='itemDetails.php?itemId=$itemId' class='btn btn-secondary btn-lg'>Back</a>
	                </div>
	            </div>
	    </div>";
}
mysqli_close($conn);
?>

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

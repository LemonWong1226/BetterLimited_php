<?php
include 'header.php';

include "conn.php";
$conn = getDBconnection();


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
        $itemDes = "";
    } else{
        $itemDes = trim($_POST["itemDes"]);
    }

    if ($success){
        // auto increment
        // save the max + 1 id first
        $sql = "SELECT max(itemID)+1 as 'next' FROM Item";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $result = mysqli_fetch_assoc($query);
        $nextId = $result['next'];

        $sql = "INSERT INTO Item(itemID, itemName, stockQuantity, price, itemDescription) VALUES('$nextId', '$itemName', '$itemQty','$itemPrice', '$itemDes')";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        Header("Location: itemDetails.php?itemId=$nextId");
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
                <a href="itemList.php" class="btn btn-secondary btn-lg">Back</a>
            </span>
            <span class="topic text-black">Create New Item</span>
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
        <form class="" action="" method="post">

            <div class=" row mx-3 my-4">
                <div class="col-md-4 col-sm-12">
                    Item Name
                </div>
                <input type="text" class="form-control col-md-6 col-sm-12" name="itemName" placeholder="Please input the item name" required>
            </div>


            <div class=" row mx-3 my-4">
                <div class="col-md-4 col-sm-12">
                    Item Quantity
                </div>
                <input type="number" class="form-control col-md-2 col-sm-12" name="itemQty" value="0" min="1" step="1" required>
            </div>

            <div class=" row mx-3 my-4">
                <div class="col-md-4 col-sm-12">
                    Item Price(HKD)
                </div>
                <input type="number" class="form-control col-md-6 col-sm-12" name="itemPrice" placeholder="Please input the price" min="0" step="1" required>
            </div>

            <div class=" row mx-3 my-4">
                <div class="col-md-4 col-sm-12">
                    Description
                </div>
                <input type="text" class="form-control col-md-6 col-sm-12" name="itemDes" placeholder="Please input the item description" >
            </div>


            <div class="mx-4 my-4">
                <button type="submit" name="submit" class="btn btn-primary col-md-2 col-sm-12"
                        onclick="return confirm('Confirm to create item ?')">Submit</button>
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


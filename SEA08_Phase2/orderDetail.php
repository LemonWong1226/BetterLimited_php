<?php
include 'header.php';

$orderId = $_GET['orderId'];
$staffId = $_GET['staffId'];

include "conn.php";
$conn = getDBconnection();

//$sql = "SELECT staffID FROM Orders WHERE orderID = '$orderId'";

if($_SESSION["position"] == "Staff" && $staffId !== $_SESSION["staffId"]) {
    header("location: errorOrder.php?staffId=$staffId");
}


?>

<!--Main Content-->

<!-- Home page and company description -->
<div class="py-2 bg-white">
    <div class="container">
        <div class="col-md-12 mx-auto pt-4">
            <h2>Order Receipt</h2>
            <hr>
        </div>
    </div>
</div>


<div class="container">
    <div class="col-md-12 ">

        <div class="orderTitle col-md-12 text-primary">
            <span>Order Id : # </span>
            <span id="orderId"><?php echo $orderId ?></span>
        </div>

        <div class="row mt-3">
            <table class="table table-hover sortable">
                <thead class="thead-dark">
                <tr>
                    <th>Item Name</th>
                    <th>Unit Price (HKD)</th>
                    <th>Quantity</th>
                </tr>
                </thead>

                <boby>
                    <?php
                    $sql = "SELECT Item.itemName, Item.price, ItemOrders.orderQuantity FROM ItemOrders inner join Item on ItemOrders.itemID = Item.itemID WHERE orderID = '$orderId'";
                    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    if (mysqli_num_rows($query) > 0){
                        while($result = mysqli_fetch_assoc($query)){
                            echo <<<EOF
                    <tr>
					    <td>$result[itemName]</td>
                        <td>$result[price]</td>
                        <td>$result[orderQuantity]</td>
					</tr>
EOF;
                        }
                    } else {
                        echo <<<EOF
                    <tr>
                        <td>No such record</td>
                        <td></td>
                        <td></td>
                    </tr>
EOF;
                    }
                    ?>
                </boby>
            </table>
        </div>

        <?php
                $sql = "SELECT Orders.customerEmail, Customer.customerName, Customer.phoneNumber, Orders.staffID, Orders.dateTime, Orders.deliveryAddress, Orders.deliveryDate, Orders.orderAmount 
FROM Orders INNER JOIN Customer ON Customer.customerEmail = Orders.customerEmail  WHERE orderID = '$orderId'";
                $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                if($result2 = mysqli_fetch_assoc($query)) {
                    echo <<<EOF
        <div class="py-4">
            <div class='detailTitle row mt-3 py-4'>
                <div class='col-md-5 col-sm-12 text-secondary'>
                    Customer's Email
                </div>
                <div class='detailContent col-md-7 col-sm-12 '>
                    $result2[customerEmail]
                </div>
            </div>

            <div class='detailTitle row my-3'>
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Customer's Name
                </div>
                <div class='detailContent col-md-7 col-sm-12 '>
                    $result2[customerName]
                </div>
            </div>

            <div class='detailTitle row my-3 py-4'>
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Customer’s Phone Number
                </div>
                <div class='detailContent col-md-7 col-sm-12'>
                    $result2[phoneNumber]
                </div>
            </div>

            <div class='detailTitle row my-3'>
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Staff ID
                </div>
                <div class='detailContent col-md-7 col-sm-12 '>
                    $result2[staffID]
                </div>
            </div>


            <div class='detailTitle row my-3 pt-4'>
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Order Date &amp; Time
                </div>
                <div class='detailContent col-md-7 col-sm-12 '>
                    $result2[dateTime]
                </div>
            </div>

            <div class='detailTitle row my-3 py-4'>
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Delivery Address
                </div>
                <div class='detailContent col-md-7 col-sm-12 '>
                    $result2[deliveryAddress]
                </div>
            </div>

            <div class='detailTitle row mt-3 '>
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Delivery Date
                </div>
                <div class='detailContent col-md-7 col-sm-12 '>
                    $result2[deliveryDate]
                </div>
            </div>

            <div class='detailTitle row my-3 py-4'>
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Total Amount(HKD)
                </div>
                <div class='detailContent col-md-7 col-sm-12 '>
                    $result2[orderAmount]
                </div>
            </div>
EOF;
        if($_SESSION["position"] == "Staff") {
                    echo <<<EOF
            <div class='row'>
                <div class='col-md-2  col-sm-12'>
                    <a href="editOrder.php?orderId=$_GET[orderId]" class='btn btn-primary btn-lg'>Edit</a>
                </div>
                
                <div class='col-md-2  col-sm-12'>
                    <a href='deleteOrder.php?orderId=$_GET[orderId]' class='btn btn-danger btn-lg' onclick="return confirm('Confirm to delete the order record ?')">Delete</a>
                </div>
            </div>
EOF;
        }
            if($_SESSION["position"] == "Staff") {
                            echo <<<EOF
            <div class='row'>
                <div class='col-md-5  col-sm-12 mt-5'>
                    <a href='orderRecord.php' class='btn btn-secondary btn-lg'>Back</a>
                </div>
            </div>
EOF;
                    }
            if ($_SESSION["position"] == "Manager") {
                        echo <<<EOF
            <div class='row'>
                <div class='col-md-5  col-sm-12 mt-5'>
                    <a href='customerDetail.php?cusEmail=$result2[customerEmail]' class='btn btn-secondary btn-lg'>Back</a>
                </div>
            </div>
EOF;
        }

            }
        ?>
        </div>
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

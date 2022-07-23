<?php
include 'header.php';

include "conn.php";
$conn = getDBconnection();

$orderId = $_GET['orderId'];

$error_message = $something_error = "";
$deliveryAddress = $deliveryDate = "";
$success = true;
$isDelAdd = $isDelDate = false;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(empty(trim($_POST["delAdd"]))){
        $error_message .= "Delivery address is missing";
    } else{
        $isDelAdd = true;
        $deliveryAddress = trim($_POST["delAdd"]);
    }
    if(empty(($_POST["delDate"]))){
        $error_message = "Delivery date is missing";
    } else{
        $isDelDate = true;
        $deliveryDate = ($_POST["delDate"]);
    }

//      update the order details
    if (!$isDelDate && !$isDelAdd){
        $sql = "UPDATE Orders SET deliveryAddress = NULL, deliveryDate = NULL WHERE orderID = '$orderId'";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // get staff id
        $sql = "SELECT staffID FROM Orders  WHERE orderID = '$orderId'";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $staffId = mysqli_fetch_assoc($query);
        Header("Location: orderDetail.php?orderId=$orderId&staffId=$staffId[staffID]");
    }else if($isDelDate && $isDelAdd){
        $sql = "UPDATE Orders SET deliveryAddress = '$deliveryAddress', deliveryDate = '$deliveryDate' WHERE orderID = '$orderId'";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // get staff id
        $sql = "SELECT staffID FROM Orders  WHERE orderID = '$orderId'";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $staffId = mysqli_fetch_assoc($query);
        Header("Location: orderDetail.php?orderId=$orderId&staffId=$staffId[staffID]");
    }
}


?>




<!--Main Content-->

<!-- Home page and company description -->
<div class="py-2 bg-white">
	<div class="container">
		<div class="col-md-12 mx-auto py-4">
			<h2>Edit Record</h2>
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
	<div class="col-md-12 ">

		<form class="" action="" method="POST">

			<div class="orderTitle col-md-12 text-primary">
				Order Id : # <?php echo$orderId?>
			</div>

			<div class="row mt-4">
				<table class="table table-hover">
					<thead class="thead-dark">
						<tr>
							<th>Item Name</th>
							<th>Price (HKD)</th>
							<th>Quantity</th>
						</tr>
					</thead>

					<boby>
						<?php
                        $sql = "SELECT Item.itemName, Item.price, ItemOrders.orderQuantity 
FROM ItemOrders inner join Item on ItemOrders.itemID = Item.itemID WHERE orderID = '$orderId'";
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
                    <div class='col-md-5  col-sm-12 text-secondary'>
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

                <div class="detailTitle row my-3 py-4">
                    <div class='col-md-5  col-sm-12 text-secondary'>
                        Delivery Address
                    </div>
                    <input type="text" class="form-control col-md-7 col-sm-12" name="delAdd" placeholder="Please input delivery address" value="$result2[deliveryAddress]">
                </div>

                <div class="detailTitle row my-3">
                    <div class='col-md-5  col-sm-12 text-secondary'>
                        Delivery Date
                    </div>
                    <input type="date" class="form-control col-md-7 col-sm-12" name="delDate" value="$result2[deliveryDate]">
                </div>


                <div class='detailTitle row my-3 py-4'>
                    <div class='col-md-5  col-sm-12 text-secondary'>
                        Total Amount(HKD)
                    </div>
                    <div class='detailContent col-md-7 col-sm-12 '>
                        $result2[orderAmount]
                    </div>
                </div>

                <div class='row'>
                    <div class='col-8 mt-5'>
                        <a href='orderDetail.php?orderId=$_GET[orderId]&staffId=$result2[staffID]' class='btn btn-secondary btn-lg'>Back</a>
                    </div>
EOF;
                }
?>
			<!--   salesperson do not have permission to delete the customer -->
			<div class='col-4 mt-5 '>
				<button type="submit" name="editConfirm" class="btn btn-lg btn-danger" onclick="return confirm('Confirm to edit this order record ?')">Confirm</button>
			</div>
	</div>
</div>
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

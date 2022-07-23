<?php
include 'header.php';

include "conn.php";
$conn = getDBconnection();

$cusEmail = $_GET['cusEmail'];
//$itemId = $conn->real_escape_string($itemId);
$sql = "SELECT * FROM Customer WHERE customerEmail = '$cusEmail'";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

?>




<!--Main Content-->

<!-- Home page and company description -->
<div class="py-2">
	<div class="container">
		<div class="col-md-12 mx-auto py-2">
			<h2>Customer Details</h2>
			<hr>
		</div>
	</div>
</div>

<?php
if (mysqli_num_rows($query) > 0) {
    $result = mysqli_fetch_assoc($query);
    echo <<<EOF
<div class="container">
    <div class="col-md-12 ">

        <div class="py-3" >

            <div class='detailTitle row py-4'>
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Customer's Email
                </div>
                <div class='detailContent col-md-7 col-sm-12 '>
                    $result[customerEmail]
                </div>
            </div>

            <div class='detailTitle row my-3'>
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Customer's Name
                </div>
                <div class='detailContent col-md-7 col-sm-12 '>
                    $result[customerName]
                </div>
            </div>

            <div class='detailTitle row my-3 py-4'>
                <div class='col-md-5  col-sm-12 text-secondary'>
                    Customer’s Phone Number
                </div>
                <div class='detailContent col-md-7 col-sm-12'>
                    $result[phoneNumber]
                </div>
            </div>
        </div>
    </div>
</div>
EOF;
}else{
    echo"<div class='container'>
	           <div class='row mt-2'>
	                <div class='col-12'>
	                    <h4> something wrong in customer details</h4>
	                </div>
	            </div>
	    </div>";
}
?>


<div class="py-2">
	<div class="container">
		<div class="col-md-12 mx-auto">
			<hr>
			<h2>Customer's Order Details</h2>
		</div>
	</div>
</div>


<div class="container">
	<div class="col-md-12 ">

		<div class="py-3">

			<div class="row">
				<table class="table table-hover table-nonfluid sortable">
					<thead class="thead-dark">
						<tr>
							<th>Order #</th>
							<th>Staff Id</th>
							<th>Date / Time</th>
							<th>Total Amount</th>
							<th>Details</th>
						</tr>
					</thead>

					<body>
						<?php

                    $sql2 = "SELECT orderID, dateTime, orderAmount, staffID FROM Orders WHERE customerEmail = '$cusEmail'";
                    $query2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

                    if (mysqli_num_rows($query2) > 0) {
                        while($result2 = mysqli_fetch_assoc($query2)){
                            echo <<<EOF
                                <tr>
                                    <td>$result2[orderID]</td>
                                    <td>$result2[staffID]</td>
                                    <td>$result2[dateTime]</td>
                                    <td>$result2[orderAmount]</td>
                                    <td><a href="orderDetail.php?orderId=$result2[orderID]&staffId=$result2[staffID]">Details</a></td>
                                </tr>
EOF;
                        }
                    }else {
                        echo <<<EOF
                    <tr>
                        <td>/</td>
                        <td>No order record for this customer</td>
                        <td></td>
                        <td></td>
                    </tr>
EOF;
                    }
                    mysqli_close($conn);
                    ?>
					</body>
				</table>
			</div>

			<div class='row'>
				<div class='col-2 mt-5'>
					<a href='customerList.php' class='btn btn-secondary btn-lg'>Back</a>
				</div>

				<!--   salesperson do not have permission to delete the customer -->
				<div class='col-3 mt-5'>
					<?php
                    if (isset($_SESSION["position"]) && $_SESSION["position"] == "Manager") {
                        echo <<<EOF
                     <a href="deleteCustomer.php?cusEmail=$cusEmail" onclick="return confirm('Confirm to delete the customer and its order record ?')"
                       class="btn btn-danger btn-lg">Delete</a>
EOF;
                    }
                    ?>
				</div>
			</div>

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

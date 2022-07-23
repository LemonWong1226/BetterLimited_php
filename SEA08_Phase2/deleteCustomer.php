<?php
include 'header.php';

include "conn.php";
$conn = getDBconnection();
$error_message = "";
$cusEmail = $_GET['cusEmail'];
$something_error = "";
$itemArray = array();
$items = "";

// select order
$sql = "SELECT * FROM Orders WHERE customerEmail = '$cusEmail'";
//echo"$sql";
//$error_message .= "#1 - $sql<br>";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

//  save the order id into the array
    if (mysqli_num_rows($query) > 0) {
        while($row = mysqli_fetch_assoc($query)){
            $items = $row['orderID'];
            $itemArray[] = $items;
//            print("$items");
//            print("</br>   ");
//            $error_message .= $items;
        }
    }

    foreach ($itemArray as $array){
//        echo $array." ";
        $sql2 = "DELETE FROM ItemOrders WHERE orderID = '$array'";
        $query = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
    }

    // 3: select order where customerEmail
    $sql = "SELECT * FROM Orders WHERE customerEmail = '$cusEmail'";
//    $error_message .= "#3 select order where customerEmail- $sql<br>";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));


    // delete the order data
    if (mysqli_num_rows($query) > 0){
        $sql = "DELETE FROM Orders WHERE customerEmail = '$cusEmail'";
//        $error_message .= "#4 delete order where customerEmail- $sql<br>";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $num = mysqli_affected_rows($conn);
        if($num == 0){
            echo "Record not found";
        }
    }

        // delete the customer record
    $sql = "SELECT * FROM Customer WHERE customerEmail = '$cusEmail'";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    if (mysqli_num_rows($query) > 0) {
        $sql = "DELETE FROM Customer WHERE customerEmail = '$cusEmail'";
//        $error_message .= "#5 delete customer where customerEmail- $sql<br>";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $num = mysqli_affected_rows($conn);
        if($num == 0){
            echo "Record not found";
        }

        echo <<<EOF
                <div class="py-2 bg-white">
                    <div class="container ">
                        <div class="text-center py-5">
                            <div class="col-md-12 mx-auto py-5">
                                <div class="text-black" id="bigTopic"> <b>The customer record deleted successfully</b></div>
                            </div>
    
                            <div>
                                <a href="customerList.php" class="btn btn-secondary btn-lg">Click here to view the customer list</a>
                            </div>
    
                        </div>
                    </div>
                </div>
EOF;
    } else {
        $something_error = "Something Wrong here, maybe the item does not exist, please check";
    }
mysqli_close($conn);

if(!empty($error_message)){
    echo '<div class="alert alert-danger">' . $error_message . '</div>';
}
if(!empty($something_error)){
    echo '<div class="alert alert-danger">' . $something_error . '</div>';
}
?>



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

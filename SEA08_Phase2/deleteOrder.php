<?php
include 'header.php';

include "conn.php";
$conn = getDBconnection();

$orderId = $_GET['orderId'];
$something_error = "";

$sql = "SELECT * FROM Orders WHERE orderID = '$orderId'";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

if (mysqli_num_rows($query) > 0){

    // delete the child data first
    $sql = "DELETE FROM ItemOrders WHERE orderID = '$orderId'";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // delete the order record
    $sql = "DELETE FROM Orders WHERE orderID = '$orderId'";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    $num = mysqli_affected_rows($conn);
    if($num == 0){
        echo "No record has been found";
    }

    echo <<<EOF
            <div class="py-2 bg-white">
                <div class="container ">
                    <div class="text-center py-5">
                        <div class="col-md-10 mx-auto py-5">
                            <div class="text-black" id="bigTopic"> <b>The order id #$orderId  has been deleted</b></div>
                        </div>
            
                        <div>
                            <a href="orderRecord.php" class="btn btn-secondary btn-lg">Click here to view the order list</a>
                        </div>
            
                    </div>
                </div>
            </div>
EOF;
} else {
    $something_error = "Something Wrong here, maybe the item does not exist, please check";
}
mysqli_close($conn);

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


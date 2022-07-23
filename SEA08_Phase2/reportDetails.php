<?php
include 'header.php';

// only Manager can use this function
manager();

include "conn.php";
$conn = getDBconnection();

$date = $_GET['date'];
//$dataNew = $date + "%";
//$itemId = $conn->real_escape_string($itemId);

?>

<!--Main Content-->

<!-- Home page and company description -->
<div class="py-2 bg-white">
    <div class="container">
        <div class="col-md-12 mx-auto py-4">
            <h2><?php echo $date ?> Monthly Report</h2>
            <hr>
        </div>
    </div>
</div>

<?php
$sql = "SELECT DISTINCT Orders.staffID, Staff.staffName FROM Orders inner join Staff on Orders.staffID = Staff.staffID WHERE dateTime LIKE '$date%'";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_num_rows($query) > 0) {
    while ($result = mysqli_fetch_assoc($query)) {
        echo <<< EOF
<div class="container">
    <div class="col-md-12 ">
        <div class='staff row py-4'>
            <div class='col-md-5  col-sm-12 text-secondary'>
                Staff id：
            </div>
            <div class='detailContent col-md-7 col-sm-12 '>
                $result[staffID]
            </div>
        </div>

        <div class='staff row py-4'>
            <div class='col-md-5  col-sm-12 text-secondary'>
                Staff Name：
            </div>
            <div class='detailContent col-md-7 col-sm-12 '>
                $result[staffName]
            </div>
        </div>
EOF;
        $sql2 = "SELECT COUNT(orderID) as 'order', SUM(orderAmount) as 'sum' FROM Orders inner join Staff on Orders.staffID = Staff.staffID WHERE dateTime LIKE '$date%' and Staff.staffID = '$result[staffID]'";
        $query2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
        if ($row = mysqli_fetch_assoc($query2)) {
            echo <<< EOF
        <div class='staff row py-4'>
            <div class='col-md-5  col-sm-12 text-secondary'>
                Number of order records in this month
            </div>
            <div class='detailContent col-md-7 col-sm-12 '>
                $row[order]
            </div>
        </div>

        <div class='staff row mt-3 py-4'>
            <div class='col-md-5  col-sm-12 text-secondary'>
                Total sales amount in this month(HKD)
            </div>
            <div class='detailContent col-md-7 col-sm-12 '>
                $row[sum]
            </div>
        </div>
EOF;
        }
        echo <<< EOF
    </div>
    <hr>
</div>
EOF;
    }
}else if(mysqli_num_rows($query) <= 0){
    echo <<< EOF
            <div class="py-2 bg-white">
                <div class="container ">
                    <h3 class="py-10">
                            <h4>&nbsp;&nbsp;&nbsp;No record have been found on $date</h4>
                    </div>
                </div>
            </div>
EOF;

}
?>

<div class="container">
    <div class="col-md-12 my-5">
        <a href='reportHome.php' class='btn btn-secondary btn-lg'>Back</a>
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

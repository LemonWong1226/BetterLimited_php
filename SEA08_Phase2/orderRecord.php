<?php
include 'header.php';
?>


<!--Main Content-->

<!-- Home page and company description -->

<div class="py-2 bg-white">
    <div class="container">
        <div class="col-md-12 mx-auto py-4">
            <h2>Order Record List</h2>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="text-center">
        <table class="table mt-1 sortable">
            <thead class="thead-dark">
            <tr>
                <th>Order Id</th>
                <th>Staff Id</th>
                <th>Date / Time</th>
                <th>Total Amount</th>
                <th>Details</th>
            </tr>
            </thead>

            <body>
            <?php
            include "conn.php";
            $conn = getDBconnection();
            $sql = "SELECT * FROM Orders";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            if (mysqli_num_rows($query) > 0){
                while($result = mysqli_fetch_assoc($query)){
                    echo <<< EOF
					<tr>
					    <td>$result[orderID]</td>
					    <td>$result[staffID]</td>
                        <td>$result[dateTime]</td>
                        <td>$result[orderAmount]</td>
                        <td><a href='orderDetail.php?orderId=$result[orderID]&staffId=$result[staffID]'>Details</a></td>
					</tr>
EOF;
                }
            } else {
                echo <<< EOF
					<tr>
					    <td>/</td>
                        <td>No order record</td>
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

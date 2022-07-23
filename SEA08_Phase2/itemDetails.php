<?php
include 'header.php';

// only Manager can use this function
manager();

include "conn.php";
$conn = getDBconnection();

$itemId = $_GET['itemId'];
$sql = "SELECT * FROM Item WHERE itemID = '$itemId'";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

?>

<!--Main Content-->

<!-- Home page and company description -->
<div class="py-2 bg-white">
    <div class="container">
        <div class="col-md-12 mx-auto py-4">
            <h2>Item Details</h2>
            <hr>
        </div>
    </div>
</div>

<?php
if (mysqli_num_rows($query) > 0){
$result = mysqli_fetch_assoc($query);
    echo <<<EOF
    <div class="container">
        <div class="col-md-12 ">
    
            <div class="pd-5">
    
                <div class='detailTitle row mt-3 py-4'>
                    <div class='col-md-5  col-sm-12 text-secondary'>
                        Item Id
                    </div>
                    <div class='detailContent col-md-7 col-sm-12 '>
                        $result[itemID]
                    </div>
                </div>
    
                <div class='detailTitle row my-3'>
                    <div class='col-md-5  col-sm-12 text-secondary'>
                        Item Name
                    </div>
                    <div class='detailContent col-md-7 col-sm-12 '>
                        $result[itemName]
                    </div>
                </div>
    
                <div class='detailTitle row my-3 py-4'>
                    <div class='col-md-5  col-sm-12 text-secondary'>
                        Stock Quantity
                    </div>
                    <div class='detailContent col-md-7 col-sm-12'>
                        $result[stockQuantity]
                    </div>
                </div>
    
                <div class='detailTitle row my-3'>
                    <div class='col-md-5  col-sm-12 text-secondary'>
                        Price(HKD)
                    </div>
                    <div class='detailContent col-md-7 col-sm-12 '>
                        $result[price]
                    </div>
                </div>
    
                <div class='detailTitle row mt-y py-4'>
                    <div class='col-md-5  col-sm-12 text-secondary'>
                        Description
                    </div>
                    <div class='detailContent col-md-7 col-sm-12 '>
                        $result[itemDescription]
                    </div>
                </div>
    
                <div class='row'>
                    <div class='col-3 mt-5'>
                        <a href='itemList.php' class='btn btn-secondary btn-lg'>Back</a>
                    </div>
                     <div class='col-6 mt-5'>
                        <a href='deleteItem.php?itemId=$itemId' onclick="return confirm('Confirm to delete this item ?')" class='btn btn-danger btn-lg'>Delete</a>
                    </div>
    
                    <div class='col-3 mt-5 '>
                        <a href='itemEdit.php?itemId=$result[itemID]' class='btn btn-primary btn-lg'>Edit</a>
                    </div>
                </div>
    
    
            </div>
        </div>
    </div>
EOF;
} else {
    echo"<div class='container'>
	           <div class='row mt-2'>
	                <div class='col-12'>
	                    <a href='itemList.php' class='btn btn-secondary btn-lg'>Back</a>
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

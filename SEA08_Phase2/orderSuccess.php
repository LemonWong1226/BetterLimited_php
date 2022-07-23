<?php
include 'header.php';

$orderId = $_GET['orderId'];
$staffId = $_GET['staffId'];
$discount = $_GET['discount'];
$amount = $_GET['amount'];
$original = $_GET['original'];
?>

<!--Main Content-->

<!-- Home page and company description -->
<div class="py-2 bg-white">
    <div class="container ">
        <div class="text-center py-5">
            <?php
            echo <<< EOF
            <div class="col-md-10 text-center mx-auto py-5">
                <div class="text-black" id="bigTopic"> <b>The order #$orderId has been created</b></div>
            </div>
            <div class="col-md-10 text-center mx-auto py-5">
                <div class="text-black" id="bigTopic"> <b>The Original Amount : $original</b></div>
                <div class="text-black" id="bigTopic"> <b>The Discount: $discount</b></div>
                <div class="text-black" id="bigTopic"> <b>The Total Amount : $amount</b></div>
EOF;
                ?>
            </div>
            <div>
                <a href="order.php" class="btn btn-primary btn-lg">Place a new order</a>
                <?php
                    echo <<< EOF
                    <a href="orderDetail.php?orderId=$orderId&staffId=$staffId" class="btn btn-secondary btn-lg">Click here to view the order details</a>
EOF;
                ?>
            </div>

        </div>
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

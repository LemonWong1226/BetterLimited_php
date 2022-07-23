<?php
include 'header.php';


include "conn.php";
$conn = getDBconnection();

$error_message = $something_error = "";
$message = "";
$discount = $customerEmail = $deliveryAddress = $deliveryDate = "";
$success = true;
$itemsArray = array();

$abcArray = array();

$unitSoldPrice = 0;
$sum = 0;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(empty(trim($_POST["cusEmail"]))){
        $error_message = "Customer Email is missing";
        $success = false;
    } else{
        $customerEmail = trim($_POST["cusEmail"]);
        $getCusEmail = "SELECT * FROM Customer WHERE customerEmail = '$customerEmail'";
        $getCusEmailQuery = mysqli_query($conn, $getCusEmail) or die(mysqli_error($conn));
        if (mysqli_num_rows($getCusEmailQuery) <= 0){
            $success = false;
            $error_message = "Customer Email is not found, please sign up first";
        }
    }
    if(!empty(trim($_POST["delAdd"]))){
        $deliveryAddress = trim($_POST["delAdd"]);
    }
    if(!empty(($_POST["delDate"]))){
        $deliveryDate = ($_POST["delDate"]);
        $message = $deliveryDate;
    }

    foreach ($_POST as $key=>$quantity){
        if ($quantity > 0){
            if (substr( $key, 0, 7 ) === "qtyBuy_"){
                // not checked: Foreign Key Constraint -- expected to fail if data is altered
                $item = substr($key, 7);
                // array_push($goodsNumbers, $goodsNumber);
                $itemsArray[$item] = $quantity;
            }
        }
    }
    // marking array
//    echo '<pre>'; print_r($item); echo '</pre>';
//    var_dump($item);

    if ($success) {

        // auto increment
        // save the max + 1 id be $nextId
        $sql = "SELECT max(orderID)+1 as 'next' FROM Orders";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $result = mysqli_fetch_assoc($query);
        $nextId = $result['next'];

        // insert order
        if(!empty(trim($_POST["delAdd"])) && !empty(($_POST["delDate"]))){
            $sql = "INSERT INTO Orders(orderID, customerEmail, staffID, dateTime, deliveryAddress, deliveryDate, orderAmount) 
VALUES ('$nextId', '$customerEmail', '$_SESSION[staffId]', DEFAULT , '$deliveryAddress', '$deliveryDate' , 0);";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }
        else{
            $sql = "INSERT INTO Orders(orderID, customerEmail, staffID, dateTime, deliveryAddress, deliveryDate, orderAmount) 
VALUES ('$nextId', '$customerEmail', '$_SESSION[staffId]', DEFAULT , null , null , 0);";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }

        // calculation the unit price and total amount
        foreach ($itemsArray as $item => $quantity) {
            //  get the sales price and unit price
            $sql = "select price from Item where itemID = '$item'limit 1";
//            $error_message .= "#$sql<br>";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $result = mysqli_fetch_assoc($query);
            $unitPrice = $result["price"];
            $unitSoldPrice = $unitPrice * $quantity;
            $sum += $unitSoldPrice;


            //     insert the items into the itemOrder table
            $sql = "INSERT INTO ItemOrders(orderID, itemID, orderQuantity, soldPrice) VALUES ('$nextId','$item','$quantity','$unitSoldPrice');";
//            $error_message .= "$sql<br>";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            //     update the inventory stock quantity
            $sql = "UPDATE Item SET stockQuantity = stockQuantity - $quantity where itemID = '$item';";
//            $error_message .= "$sql<br>";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            //      update the order amount of the order
            $sql = "UPDATE Orders SET orderAmount = $sum where orderID = '$nextId';";
//        $error_message .= "$sql<br>";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        }

        // call the python api
        // check if library curl is enabled
        if (!extension_loaded("curl")) {
            die("enable library curl first");
        }

        if($sum >= 3000 && $sum < 5000){
            $para1 = "3";
            $discount = "3%";
        }else if($sum >= 5000 && $sum < 10000){
            $para1 = "8";
            $discount = "8%";
        }else if($sum >= 10000){
            $para1 = "12";
            $discount = "12%";
        }else{
            $para1 = "0";
            $discount = "/";
        }
        $para2 = $sum;
        $url = "http://127.0.0.1:8080/api/$para1/$para2";
        // Initializes a new cURL session
        $curl = curl_init($url);
        // to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);   # Perform a cURL session
        curl_close($curl);
        // Assume response data is in JSON format
        $data = json_decode($response, true);



        //      update the new order amount of the order
        $sql = "UPDATE Orders SET orderAmount = $data[amount] where orderID = '$nextId';";
//        $error_message .= "$sql<br>";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // the order is successfully
          header("location: orderSuccess.php?orderId=$nextId&staffId=$_SESSION[staffId]&discount=$discount&amount=$data[amount]&original=$sum");
    }
}

?>


<!--Main Content-->

<!-- Home page and company description -->
<div class="py-2 bg-white">
    <div class="container">
        <div class="col-md-12 mx-auto py-4">
            <h2>Place Order</h2>
            <hr>
        </div>
    </div>
</div>

<?php
if(!empty($message)){
    echo '<div class="alert alert-primary">' . $message . '</div>';
}
if(!empty($error_message)){
    echo '<div class="alert alert-danger">' . $error_message . '</div>';
}
if(empty($error_message) && !empty($something_error)){
    echo '<div class="alert alert-danger">' . $something_error . '</div>';
}
?>

<div class="container">
    <div class="col-md-12 ">

        <form id="form" class="" action="" method="POST">

            <div class="row">
                <table class="table table-hover sortable" id="forLoop">
                    <thead class="thead-dark">
                    <tr>
                        <th>Item Id</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Item in stock</th>
                        <th>Quantity for buy</th>
                    </tr>
                    </thead>


                    <boby>
                        <?php

                        $sql = "SELECT * from Item WHERE stockQuantity > 0";
                        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                        if (mysqli_num_rows($query) > 0){
                            while($result = mysqli_fetch_assoc($query)){
                                echo <<< EOF
                                <tr>
                                    <td>$result[itemID]</td>
                                    <td>$result[itemName]</td>
                                    <td>$result[price]</td>
                                    <td>$result[stockQuantity]</td>
                                    <td><input type="number" name="qtyBuy_$result[itemID]" min="0" max="$result[stockQuantity]"></td>
                                </tr>
EOF;
                            }
                        } else {
                            echo <<< EOF
                        <tr>
                            <td>/</td>
                            <td>No item for buy, sorry</td>
                            <td>/</td>
                            <td>/</td>
                            <td>/</td>
                        </tr>
EOF;
                        }
                        mysqli_close($conn);
                        ?>
                    </boby>
                </table>
            </div>

            <div class="py-4">

                <div class="py-4" style="font-size:20px">
                    <div class="form-group">
                        <label>Customer's Email</label>
                        <input type="email" class="form-control col-md-8 col-sm-6" name="cusEmail" placeholder="Please input customer email" required>
                    </div>

                    <div class="py-4">
                        <input type="checkbox" id="clickDel" name="deliveryOrder">
                        <label for="clickDel">Delivery Order</label>

                        <div class="hint text-danger">
                            if select the delivery order, you must be input the delivery address and date.
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Delivery Address</label>
                        <input type="text" class="delivery form-control col-md-8 col-sm-6" name="delAdd" placeholder="Please input delivery address">
                    </div>

                    <div class="form-group">
                        <label>Delivery Date</label>
                        <input type="date" class="delivery form-control col-md-8 col-sm-6" name="delDate">
                    </div>
                </div>


<!--                  if will calculate the total prices-->
<!--                <div class="text-right" id="totalPrice">-->
<!--                    <div>-->
<!--                        Original Total(HKD):-->
<!--                        <span class="text-info" id="oriTotal">0</span>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        Discount(%):-->
<!--                        -->
<!--                        if($sum >= 3000 && $sum < 5000){-->
<!--                            echo <<< EOF-->
<!--                            <span class="text-info" id="discount">3</span>-->
<!--EOF;-->
<!--                        }else if($sum >= 5000 && $sum < 10000){-->
<!--                            echo <<< EOF-->
<!--                            <span class="text-info" id="discount">8</span>-->
<!--EOF;-->
<!--                        }else if($sum >= 10000){-->
<!--                            echo <<< EOF-->
<!--                            <span class="text-info" id="discount">12</span>-->
<!--EOF;-->
<!--                        }else{-->
<!--                            echo <<< EOF-->
<!--                            <span class="text-info" id="discount">0</span>-->
<!--EOF;-->
<!--                        }-->
<!--                        -->
<!---->
<!--                    </div>-->
<!--                    Total Amount(HKD):-->
<!--                    <span class="text-info" id="totalAmount">0</span>-->
<!--                    <br>-->
<!--                    <br>-->
                    <button type="submit" name="checkout" id="checkout" class="btn btn-danger">Checkout</button>

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


<script>
    // if select the delivery order checkbox, the delivery address and date must be input.
    $(function() {
        isDelivery();
        $("#clickDel").click(isDelivery);
    });

    function isDelivery() {
        if (this.checked) {
            $("input.delivery").removeAttr("disabled");
            $("input.delivery").attr("required", true);
        } else {
            $("input.delivery").attr("disabled", true);
            $("input.delivery").removeAttr("required");
        }
    }

</script>


</body>

</html>

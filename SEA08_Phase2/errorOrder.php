<?php
include 'header.php';
$staffId = $_GET['staffId'];


?>

<div class="container">
    <div class="col-md-6 mx-auto mt-4">
        <div class="card-body text-center">
               <h3>You can not view this order</h3>
            <br>
               <h3>The order belong to <?php echo"$_GET[staffId]" ?></h3>
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
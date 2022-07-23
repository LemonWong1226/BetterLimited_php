<?php
include 'header.php';


// only Manager can use this function
manager();

$something_error = "";
$date = "";
$success = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(empty(($_POST["report"]))){
        $success = false;
    } else{
        $date = ($_POST["report"]);
    }

    if ($success){
        Header("Location: reportDetails.php?date=$date");
    }else{
        $something_error = "Something error, Please check.";
    }
}
//mysqli_close($conn);
?>


<!--Main Content-->

<!-- Home page and company description -->

<div class="py-2 bg-white">
    <div class="container">

        <div class="col-md-12 mx-auto py-4">
            <h2>Monthly Report</h2>
            <hr>
        </div>


    </div>
</div>

<?php
if(!empty($something_error)){
    echo '<div class="alert alert-danger">' . $something_error . '</div>';
}
?>

<div class="container">
    <div class="text-left">

        <div class="col-md-12 ml-1">
            Please select the month that you want to generate, then click the submit button.
        </div>
        <form class="" action="" method="POST">

            <div class="col-md-4 py-4">
                <input type="month" id="report" name="report" min="2022-01" value="2022-07">
            </div>

            <button type="submit" name="submit" class="btn btn-danger my-5 ml-3">Submit</button>
        </form>
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
